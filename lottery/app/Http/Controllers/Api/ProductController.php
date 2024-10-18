<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Traits\AttachmentTrait;

class ProductController extends Controller
{
    use AttachmentTrait;
    public function get_products()
    {
        $products =  DB::table('products')
        // ->whereDate('products.expirey_date', '>=', now())
        ->select('products.id', 'products.attachment_id', 'products.name',
        'products.price', 'products.token_price', 'products.expirey_date','products.description')
        ->get();

        $data['products'] = $products->map(function($product){
            $user_applied = DB::table('lottery_requests')
            ->where('user_id', request()->user()->id)
            ->where('product_id', $product->id)
            ->whereIn('status',['requested','winner'])
            ->where('lottery_announced', 0)->select('id')->first();
    
            $winner_announced = DB::table('lottery_requests')
            ->where('product_id', $product->id)
            ->where('status','winner')->select('id')->first();
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'token_price' => $product->token_price,
                'attachment' => uploaded_asset($product->attachment_id),
                'expirey_date' => $product->expirey_date,
                'description' => $product->description,
                'users_applied_for_lottery' => DB::table('lottery_requests')->where('product_id', $product->id)->where('status','requested')->where('lottery_announced', 0)->count(),
                'is_this_user_applied_for_this_product' => ($user_applied)?1:0,
                'is_winner_announced_for_this_product' => ($winner_announced)?1:0
            ];
        });
        
        $winner_users = DB::table('lottery_requests as l_r')
        ->where('l_r.status', 'winner')
        ->join('users as u', 'u.id', '=', 'l_r.user_id')
        ->leftJoin('attachments', 'attachments.id', '=', 'u.attachment_id')
        ->select('u.id','u.name',DB::raw('CONCAT("' . my_asset('uploads/') . '/", attachments.attachment) as user_image'))
        ->groupBy('u.id','u.name','attachments.attachment')
        ->get();

        return response()->json([
            'result' => true,
            'data' => $data,
            'winner_users' => $winner_users,
            'message' => ''
        ], 200);
    }

    public function store(Request $request)
    {
        $products_uploaded = Product::whereDay('created_at', date('d'))->count();
        if($products_uploaded >= 15){
            return response()->json([
                'result' => false,
                'data' => [],
                'message' => 'Products maximum upload limit is reached today',
            ], 201);
        }
        $attachment_id = $this->addAttachment($request->attachment);
        $product = new Product();
        $product->attachment_id = $attachment_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->token_price = $request->token_price;
        if($request->expirey_date){
        $product->expirey_date = date('Y-m-d', strtotime($request->expirey_date));
        }
        $product->description = $request->description;
        $product->save();

        return response()->json([
            'result' => true,
            'data' => [],
            'message' => 'New product added successfully',
        ], 200);
    }

    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $data = [
            'name' => $product->name,
            'price' => $product->price,
            'token_price' => $product->token_price,
            'attachment' => uploaded_asset($product->attachment_id),
            'expirey_date' => $product->expirey_date,
            'description' => $product->description,
        ];
        return response()->json([
            'result' => true,
            'data' => $data,
            'message' => '',
        ], 200);
    }

    public function details($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        $user_applied = DB::table('lottery_requests')
        ->where('user_id', request()->user()->id)
        ->where('product_id', $id)
        ->whereIn('status',['requested','winner'])
        ->where('lottery_announced', 0)->select('id')->first();

        $winner_announced = DB::table('lottery_requests')
        ->where('product_id', $id)
        ->where('status','winner')->select('id')->first();
        $data = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'token_price' => $product->token_price,
            'attachment' => uploaded_asset($product->attachment_id),
            'expirey_date' => $product->expirey_date,
            'description' => $product->description,
            'users_applied_for_lottery' => DB::table('lottery_requests')->where('product_id', $id)->where('status','requested')->where('lottery_announced', 0)->count(),
            'is_this_user_applied_for_this_product' => ($user_applied)?1:0,
            'is_winner_announced_for_this_product' => ($winner_announced)?1:0
        ];
        return response()->json([
            'result' => true,
            'data' => $data,
            'message' => '',
        ], 200);
    }

    public function update(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if ($request->hasFile('attachment')) {
            $this->removeAttachment($product->attachment_id);
            $attachment_id = $this->addAttachment($request->attachment);
        } else {
            $attachment_id = $product->attachment_id;
        }

        $product->attachment_id = $attachment_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->token_price = $request->token_price;
        if($request->expirey_date){
        $product->expirey_date = date('Y-m-d', strtotime($request->expirey_date));
        }
        $product->description = $request->description;
        $product->update();

        return response()->json([
            'result' => true,
            'data' => [],
            'message' => 'Product uploaded successfully',
        ], 200);
    }

    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
        if($product->attachment_id){
            $this->removeAttachment($product->attachment_id);
        }
        DB::table('lottery_requests')->where('product_id', $request->id)->delete();
        $product->delete();
        return response()->json([
            'result' => true,
            'data' => [],
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
