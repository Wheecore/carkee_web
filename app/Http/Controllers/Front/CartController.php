<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $category_id = '';
        $category = Category::where('slug', 'tyres')->first();
        if ($category != null) {
            $category_id = $category->id;
        }
        // cart array for cart summary sidebar
        $user_id = Auth::user()->id;
        $carts = Cart::where('user_id', $user_id)->get();
        $j = 1;
        $cart_id = 0;
        foreach ($carts as $key => $cartItem) {
            if (Session::get('tyre_product_id') == $cartItem['product_id']) {
                $cart_id =  $cartItem['id'];
            } elseif ($j == 1) {
                $cart_id =  $cartItem['id'];
            }
            $j++;
        }
        $carts = $carts->where('id', $cart_id);

        // cart array for all products
        $cartss = Cart::where('user_id', $user_id)->get();
        return view('frontend.view_cart', compact('carts', 'category_id', 'cartss'));
    }

    public function updateCartSummary(Request $request)
    {
        $carts = Cart::where('id', $request->cart_id)->get();
        $viewHtml = view('frontend.partials.cart_summary', compact('carts'))->render();
        return $viewHtml;
    }

    public function showCartModal(Request $request)
    {
        $product = Product::find($request->id);
        return view('frontend.partials.addToCart', compact('product'));
    }

    public function updateNavCart(Request $request)
    {
        return view('frontend.partials.cart');
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        Session::put('tyre_product_id', $request->id);
        $carts = array();
        $data = array();


        $user_id = Auth::user()->id;
        $data['user_id'] = $user_id;
        $carts = Cart::where('user_id', $user_id)->get();

        $cat_type = Session::get('cat_type');
        $data['category'] = $cat_type;
        $data['product_id'] = $product->id;
        $data['owner_id'] = $product->user_id;

        $str = '';
        $tax = 0;

        if ($request->quantity < $product->min_qty) {
            return array('status' => 0, 'view' => view('frontend.partials.minQtyNotSatisfied', [
                'min_qty' => $product->min_qty
            ])->render());
        }


        //check the color enabled or disabled for the product
        if ($request->has('color')) {
            $str = $request['color'];
        }

            //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if ($str != null) {
                    $str .= '-' . str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                } else {
                    $str .= str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                }
            }

        $data['variation'] = $str;

        if ($str != null && $product->variant_product) {
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $quantity = $product_stock->qty;
            if ($quantity < $request['quantity']) {
                return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
            }
        } else {
            $price = $product->unit_price;
        }

        //discount calculation
        $discount_applicable = false;

        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        //calculation of taxes
        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax) / 100;
            } elseif ($product_tax->tax_type == 'amount') {
                $tax += $product_tax->tax;
            }
        }

        $data['quantity'] = $request['quantity'];
        $data['price'] = $price;
        $data['tax'] = $tax;

        //        $data['shipping'] = 0;
        $data['shipping_cost'] = 0;
        $data['product_referral_code'] = null;
        $data['cash_on_delivery'] = $product->cash_on_delivery;

        if ($request['quantity'] == null) {
            $data['quantity'] = 1;
        }

        if (Cookie::has('referred_product_id') && Cookie::get('referred_product_id') == $product->id) {
            $data['product_referral_code'] = Cookie::get('product_referral_code');
        }

        if ($carts && count($carts) > 0) {
            $foundInCart = false;

            foreach ($carts as $key => $cartItem) {
                if ($cartItem['product_id'] == $request->id) {
                    $product_stock = $product->stocks->where('variant', $str)->first();
                    $quantity = $product_stock->qty;
                    if ($quantity < $cartItem['quantity'] + $request['quantity']) {
                        return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
                    }
                    if (($str != null && $cartItem['variation'] == $str) || $str == null) {
                        $foundInCart = true;

                        $cartItem['quantity'] += $request['quantity'];
                        $cartItem->save();
                    }
                }
            }
            if (!$foundInCart) {
                Cart::create($data);
            }
        } else {
            Cart::create($data);
        }

        return array('status' => 1, 'view' => view('frontend.partials.addedToCart', compact('product', 'data'))->render());
    }

    public function packageToCart(Request $request, $id)
    {
        $package = Package::find($id);

        $cart_package_product_a = DB::table('cart_package_products')->where('package_id', $id)->where('type', 'Addon')->where('user_id', Auth::id())->first();
        $cart_package_product_r = DB::table('cart_package_products')->where('package_id', $id)->where('type', 'Recommended')->where('user_id', Auth::id())->first();

        $a_prods = PackageProduct::where('package_id', $id)->where('type', 'Addon')->first();
        $r_prods = PackageProduct::where('package_id', $id)->where('type', 'Recommended')->first();
        //        return array_merge($a_prods,$r_prods);
        //     return   $var = $a_prods->products;

        if ($cart_package_product_a) {
            $a_prods = $cart_package_product_a ? json_decode($cart_package_product_a->products, TRUE) : ["0"];
        } else {
            $a_prods = $a_prods ? json_decode($a_prods->products, TRUE) : ["0"];
        }

        if ($cart_package_product_r) {
            $r_prods = $cart_package_product_r ? json_decode($cart_package_product_r->products, TRUE) : ["0"];
        } else {
            $r_prods = $r_prods ? json_decode($r_prods->products, TRUE) : ["0"];
        }

        $var = array_merge($a_prods, $r_prods);

        $products = array_unique($var);

        //        print_r($products);
        //        exit();
        foreach ($products as $product_id) {
            if ($product_id != 'on') {
                $product = Product::find($product_id);
                if ($product) {
                    $carts = array();
                    $data = array();

                    $user_id = Auth::user()->id;
                    $data['user_id'] = $user_id;
                    $carts = Cart::where('user_id', $user_id)->get();

                    $cat_type = Session::get('cat_type');
                    $data['category'] = $cat_type;
                    $data['product_id'] = $product_id;
                    $data['owner_id'] = $product->user_id;
                    $data['package_id'] = $package->id;

                    $str = '';
                    $tax = 0;

                    //check the color enabled or disabled for the product
                    if ($request->has('color')) {
                        $str = $request['color'];
                    }

                    $data['variation'] = $str;

                    if ($str != null && $product->variant_product) {
                        $product_stock = $product->stocks->where('variant', $str)->first();
                        $price = $product_stock->price;
                        $quantity = $product_stock->qty;

                        if ($quantity < $request['quantity']) {
                            return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
                        }
                    } else {
                        $price = $product->unit_price;
                    }

                    //discount calculation
                    $discount_applicable = false;

                    if ($product->discount_start_date == null) {
                        $discount_applicable = true;
                    } elseif (
                        strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
                        strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
                    ) {
                        $discount_applicable = true;
                    }

                    if ($discount_applicable) {
                        if ($product->discount_type == 'percent') {
                            $price -= ($price * $product->discount) / 100;
                        } elseif ($product->discount_type == 'amount') {
                            $price -= $product->discount;
                        }
                    }

                    //calculation of taxes
                    foreach ($product->taxes as $product_tax) {
                        if ($product_tax->tax_type == 'percent') {
                            $tax += ($price * $product_tax->tax) / 100;
                        } elseif ($product_tax->tax_type == 'amount') {
                            $tax += $product_tax->tax;
                        }
                    }

                    $data['quantity'] = $request['quantity'];
                    $data['price'] = $price;
                    $data['tax'] = $tax;
                    //        $data['shipping'] = 0;
                    $data['shipping_cost'] = 0;
                    $data['product_referral_code'] = null;
                    $data['cash_on_delivery'] = $product->cash_on_delivery;

                    if ($request['quantity'] == null) {
                        $data['quantity'] = 1;
                    }

                    if (Cookie::has('referred_product_id') && Cookie::get('referred_product_id') == $product_id) {
                        $data['product_referral_code'] = Cookie::get('product_referral_code');
                    }

                    if ($carts && count($carts) > 0) {
                        $foundInCart = false;

                        foreach ($carts as $key => $cartItem) {
                            if ($cartItem['product_id'] == $product_id) {
                                $product_stock = $product->stocks->where('variant', $str)->first();
                                $quantity = $product_stock->qty;
                                if ($quantity < $cartItem['quantity'] + $request['quantity']) {
                                    return array('status' => 0, 'view' => view('frontend.partials.outOfStockCart')->render());
                                }
                                if (($str != null && $cartItem['variation'] == $str) || $str == null) {
                                    $foundInCart = true;

                                    $cartItem['quantity'] += 1;
                                    $cartItem->save();
                                }
                            }
                        }
                        if (!$foundInCart) {
                            Cart::create($data);
                        }
                    } else {
                        Cart::create($data);
                    }
                }
            }
        }

        flash(translate('Cart Updated Successfully'))->success();
        return redirect()->back();
        //        return array('status' => 1, 'view' => view('frontend.partials.addedToCart', compact('product', 'data'))->render());
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        Cart::destroy($request->id);
        $category_id = '';
        $category = Category::where('slug', 'tyres')->first();
        if ($category != null) {
            $category_id = $category->id;
        }
        // cart array for cart summary sidebar
        $user_id = Auth::user()->id;
        $carts = Cart::where('user_id', $user_id)->get();
        $k = 1;
        $cart_id = 0;
        foreach ($carts as $key => $cartItem) {
            if (Session::get('tyre_product_id') == $cartItem['product_id']) {
                $cart_id =  $cartItem['id'];
            } elseif ($k == 1) {
                $cart_id =  $cartItem['id'];
            }
            $k++;
        }
        $carts = $carts->where('id', $cart_id);

        // cart array for all products
        $cartss = Cart::where('user_id', $user_id)->get();
        return view('frontend.partials.cart_details', compact('carts', 'cartss', 'category_id'));
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $object = Cart::findOrFail($request->id);
        if ($object['id'] == $request->id) {
            $product = Product::find($object['product_id']);
            $product_stock = $product->stocks->where('variant', $object['variation'])->first();
            $quantity = $product_stock->qty;

            if ($quantity >= $request->quantity) {
                if ($request->quantity >= $product->min_qty) {
                    $object['quantity'] = $request->quantity;
                }
            }
            $object->save();
        }

        $user_id = Auth::user()->id;
        $carts = Cart::where('id', $request->checked_id)->where('user_id', $user_id)->get();

        $cartss = Cart::where('user_id', $user_id)->get();
        $current_cart = Cart::findOrFail($request->checked_id);
        Session::put('tyre_product_id', $current_cart['product_id']);
        return view('frontend.partials.cart_details', compact('carts', 'cartss'));
    }
    public function removeAll(Request $request)
    {
        foreach ($request->products as $product) {
            Cart::where('product_id', $product)->delete();
        }
        flash(translate('Category Items Removed Successfully'))->success();
        return back();
    }

    public function load_order_confirmed_view($order_id)
    {
        $order = Order::find($order_id);
        return view('frontend.order_confirmed', compact('order'));
    }
}
