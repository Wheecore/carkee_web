<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = DB::table('reviews')
            ->join('products', 'products.id', '=', 'reviews.product_id')
            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('product_translations.name as product', 'products.added_by', 'users.name', 'users.email', 'reviews.comment', 'reviews.rating', 'reviews.id');
            if($request->has('rating') && $request->rating == 'rating_desc'){
                $reviews = $reviews->orderBy('reviews.rating', 'desc');
            }
            else if($request->has('rating') && $request->rating == 'rating_asc'){
                $reviews = $reviews->orderBy('reviews.rating', 'asc');
            }
            else{
                $reviews = $reviews->orderBy('reviews.created_at', 'desc');
            }
            $reviews = $reviews->paginate(15);
        return view('backend.product.reviews.index', compact('reviews'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $product = Product::find($review->product_id);
        $review->delete();
        if ($product) {
            $product_reviews = Review::where('product_id', $product->id)->where('status', 1)->count();
            if ($product_reviews > 0) {
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / $product_reviews;
            } else {
                $product->rating = 0;
            }
            $product->update();
        }
        flash(translate('Review has been deleted successfully'))->success();
        return back();
    }

    public function orders_reviews(Request $request)
    {
        $reviews = DB::table('rating_orders as ro')
            ->join('orders', 'orders.id', '=', 'ro.order_id')
            ->join('users', 'users.id', '=', 'ro.user_id')
            ->join('shops', 'shops.id', '=', 'orders.seller_id')
            ->select('users.name as user', 'shops.name as seller', 'orders.code', 'score', 'workshop_enviornment', 'job_done_on_time', 'ro.description', 'ro.features', 'ro.website_use', 'ro.money_of_product', 'ro.buy_again', 'ro.purchasing_concern', 'ro.specification_of_products', 'ro.id');
            if($request->has('rating') && $request->rating == 'rating_desc'){
                $reviews = $reviews->orderBy('ro.score', 'desc');
            }
            else if($request->has('rating') && $request->rating == 'rating_asc'){
                $reviews = $reviews->orderBy('ro.score', 'asc');
            }
            else{
                $reviews = $reviews->orderBy('ro.created_at', 'desc');
            }
            $reviews = $reviews->paginate(15);
        return view('backend.product.reviews.orders_reviews', compact('reviews'));
    }

    public function orders_review_destroy($id)
    {
        $rating = DB::table('rating_orders')->where('id', $id)->first();
        $shop = Shop::where('user_id', $rating->seller_id)->first();
        DB::table('rating_orders')->where('id', $id)->delete();
        if ($shop) {
            $shop_reviews = DB::table('rating_orders')->where('seller_id', $shop->user_id)->count();
            if ($shop_reviews > 0) {
                $shop->rating = DB::table('rating_orders')->where('seller_id', $shop->user_id)->sum('score') / $shop_reviews;
            } else {
                $shop->rating = 0;
            }
            $shop->update();
        }
        flash(translate('Order review has been deleted successfully'))->success();
        return back();
    }

    public function packages_reviews(Request $request)
    {
        $reviews = DB::table('reviews as pr')
            ->join('orders', 'orders.id', '=', 'pr.order_id')
            ->join('users', 'users.id', '=', 'pr.user_id')
            ->join('shops', 'shops.id', '=', 'orders.seller_id')
            ->select('users.name as user', 'shops.name as seller', 'orders.code', 'pr.id', 'pr.rating', 'pr.comment as description');
            if ($request->has('rating') && $request->rating == 'rating_desc'){
                $reviews = $reviews->orderBy('pr.rating', 'desc');
            } else if ($request->has('rating') && $request->rating == 'rating_asc') {
                $reviews = $reviews->orderBy('pr.rating', 'asc');
            } else {
                $reviews = $reviews->orderBy('pr.created_at', 'desc');
            }
            $reviews = $reviews->paginate(15);
        return view('backend.product.reviews.package_reviews', compact('reviews'));
    }

    public function package_review_destroy($id)
    {
        DB::table('reviews')->where('id', $id)->delete();
        flash(translate('Package review has been deleted successfully'))->success();
        return back();
    }

    public function store(Request $request)
    {
        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = Auth::user()->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->viewed = '0';
        if ($review->save()) {
            $product = Product::findOrFail($request->product_id);
            if (count(Review::where('product_id', $product->id)->where('status', 1)->get()) > 0) {
                $product->rating = Review::where('product_id', $product->id)->where('status', 1)->sum('rating') / count(Review::where('product_id', $product->id)->where('status', 1)->get());
            } else {
                $product->rating = 0;
            }
            $product->save();
            flash(translate('Product review has been submitted successfully'))->success();
            return back();
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }
}
