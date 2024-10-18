<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Battery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\CarVariant;
use App\Models\Deal;
use App\Models\Product;
use App\Models\Shop;
use App\Models\FeaturedCategory;
use App\Models\SizeCategory;
use App\Models\VehicleCategory;
use App\Models\FeaturedSubCategory;
use App\Models\SizeSubCategory;
use App\Models\SizeChildCategory;
use App\User;
use App\Models\Seller;
use App\Models\WorkshopAvailability;
use App\Models\SizeAlternative;
use App\Models\VehicleSize;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function getList(Request $request)
    {
        $data['emergency_items'] = [];
        $data['tyre_items'] = [];
        $data['package_items'] = [];
        $cart_tax = 0;
        $carts_arr['products'] = [];
        $carts_arr['packages'] = [];
        $cart_subtotal = 0;
        $cart_shipping_cost = 0;
        $locale = Session::get('locale', Config::get('app.locale'));
        $symbol = DB::table('currencies')->select('symbol')->where('id', get_setting('system_default_currency'))->first()->symbol;
        $carts = DB::table('carts')->select('id', 'package_id', 'product_id', 'battery_id', 'quantity', 'tax', 'shipping_cost', 'price', 'coupon_applied')->where('user_id', $request->user_id)->where('carlist_id', $request->carlist_id)->get()->toArray();
        $skip_ids = [];

        foreach ($carts as $cart) {
            // remove the applied coupon data that is applied if have
            if ($cart->coupon_applied == 1) {
                Cart::where('id', $cart->id)->update([
                    'discount' => 0,
                    'coupon_code' => '',
                    'coupon_applied' => 0,
                    'coupon_applied_product' => 0,
                ]);
            }

            if (!is_null($cart->product_id)) {
                $skip_ids[] = $cart->product_id;
                $product = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
                    ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
                    ->select(
                        DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_img"),
                        'products.id',
                        'product_translations.name',
                        'products.ps_status',
                        'products.brand_id',
                        'products.model_id',
                        'products.qty',
                        'products.quantity_1_price',
                        'products.greater_1_price',
                        'products.greater_3_price',
                        'products.category_id',
                        'products.discount_start_date',
                        'products.discount_end_date',
                        'products.discount_type',
                        'products.discount'
                    )
                    ->where('products.id', $cart->product_id)
                    ->where('product_translations.lang', $locale)
                    ->first();
                if ($product) {
                    // Tax and charges
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                    $tax += $cart->tax * $cart->quantity;
                    $product_shipping_cost = $cart->shipping_cost;
                    $shipping += $product_shipping_cost;

                    // Calculate Tax, Shipping, Subtotal
                    $cart_subtotal += ($cart->price * $cart->quantity);
                    $cart_tax += $tax;
                    $cart_shipping_cost += $shipping;
                    $product_brands = (array) (json_decode($product->brand_id, true) ?? []);
                    $product_models = (array) (json_decode($product->model_id, true) ?? []);

                    $data['tyre_items'][] = [
                        'cart_id' => $cart->id,
                        'product_name_with_choice' => $product->name,
                        'product_id' => $cart->product_id,
                        'thumbnail_img' => ($product->thumbnail_img) ? $product->thumbnail_img : static_asset('assets/img/tyre.png'),
                        'single_price' => (string) $cart->price,
                        'calculatable_price' => (string) (convert_price($cart->price)),
                        'currency_symbol' => $symbol,
                        'qty_1_price' => homeDiscountedBasePrice($product, $product->quantity_1_price),
                        'greater_1_price' => homeDiscountedBasePrice($product, $product->greater_1_price),
                        'greater_3_price' => homeDiscountedBasePrice($product, $product->greater_3_price),
                        'quantity' => $cart->quantity,
                        'tax' => $tax,
                        'product_shipping_cost' => $shipping,
                        'ps_status' => $product->ps_status,
                        'available_stock' => $product->qty,
                        'brands' => $this->make_brand_model_string(DB::table('brands')->whereIn('id', $product_brands)->select('name')->get()),
                        'models' => $this->make_brand_model_string(DB::table('car_models')->whereIn('id', $product_models)->select('name')->get())
                    ];
                }
            } elseif (!is_null($cart->package_id)) {
                $package_products = DB::table('cart_package_products as cpp')
                    ->join('products', 'products.id', '=', 'cpp.product_id')
                    ->join('product_translations', 'product_translations.product_id', '=', 'cpp.product_id')
                    ->leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
                    ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_img"), 'cpp.product_id', 'product_translations.name', 'cpp.quantity', 'cpp.ps_status', 'cpp.tax', 'cpp.shipping_cost', 'cpp.price')
                    ->where('cpp.package_id', $cart->package_id)
                    ->where('cpp.cart_id', $cart->id)
                    ->where('product_translations.lang', $locale)
                    ->get()
                    ->toArray();

                $products_arr = [];
                $package_total = 0;
                foreach ($package_products as $product) {
                    // Tax and charges
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                    $tax += $product->tax * 1;
                    $product_shipping_cost = $product->shipping_cost;
                    $shipping += $product_shipping_cost;
                    // Calculate Tax, Shipping, Subtotal
                    $cart_subtotal += $product->price;
                    $cart_tax += $tax;
                    $cart_shipping_cost += $shipping;
                    $products_arr[] = array(
                        'product_name_with_choice' => $product->name,
                        'product_id' => $product->product_id,
                        'thumbnail_img' => ($product->thumbnail_img) ? $product->thumbnail_img : static_asset('assets/img/tyre.png'),
                        'single_price' => single_price($product->price),
                        'calculatable_price' => (string) (convert_price($product->price)),
                        'currency_symbol' => $symbol,
                        'quantity' => $product->quantity,
                        'tax' => $tax,
                        'product_shipping_cost' => $shipping,
                        'ps_status' => $product->ps_status,
                    );
                    $package_total += ($product->price - ($cart_tax + $cart_shipping_cost));
                }

                $package_Data = DB::table('packages')
                    ->leftJoin('brands', 'brands.id', '=', 'packages.brand_id')
                    ->leftJoin('car_models', 'car_models.id', '=', 'packages.model_id')
                    ->select('brands.name as brand', 'car_models.name as model')
                    ->where('packages.id', $cart->package_id)
                    ->first();

                $data['package_items'][] = [
                    'cart_id' => $cart->id,
                    'package_id' => $cart->package_id,
                    'package_name' => 'Package',
                    'brands' => $package_Data->brand,
                    'models' => $package_Data->model,
                    'package_total' => $package_total,
                    'calculatable_package_total' => (string) (convert_price($package_total)),
                    'products' => $products_arr,
                ];
            } elseif (!is_null($cart->battery_id)) {
                $product = Battery::leftJoin('uploads', 'uploads.id', '=', 'batteries.attachment_id')
                    ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_img"), 'batteries.name', 'car_brand_id', 'car_model_id', 'stock', 'amount', 'sub_category_id', 'sub_child_category_id')
                    ->where('batteries.id', $cart->battery_id)
                    ->first();
                if ($product) {
                    // Tax and charges
                    $tax = 0;
                    $shipping = 0;
                    $product_shipping_cost = 0;
                    $tax += $cart->tax * $cart->quantity;
                    $product_shipping_cost = $cart->shipping_cost;
                    $shipping += $product_shipping_cost;

                    // Calculate Tax, Shipping, Subtotal
                    $cart_subtotal += ($cart->price * $cart->quantity);
                    $cart_tax += $tax;
                    $cart_shipping_cost += $shipping;
                    $product_brands = (array) (json_decode($product->car_brand_id, true) ?? []);
                    $product_models = (array) (json_decode($product->car_model_id, true) ?? []);

                    $data['emergency_items'][] = [
                        'cart_id' => $cart->id,
                        'product_name_with_choice' => $product->name,
                        'battery_id' => $cart->battery_id,
                        'thumbnail_img' => ($product->thumbnail_img) ? $product->thumbnail_img : static_asset('assets/img/tyre.png'),
                        'single_price' => (string) $cart->price,
                        'calculatable_price' => number_format(convert_price($cart->price), 2),
                        'currency_symbol' => $symbol,
                        'qty_1_price' => 0,
                        'greater_1_price' => 0,
                        'greater_3_price' => 0,
                        'quantity' => $cart->quantity,
                        'tax' => $tax,
                        'product_shipping_cost' => $shipping,
                        'ps_status' => '',
                        'available_stock' => $product->qty,
                        'brands' => $this->make_brand_model_string(DB::table('brands')->whereIn('id', $product_brands)->select('name')->get()),
                        'models' => $this->make_brand_model_string(DB::table('car_models')->whereIn('id', $product_models)->select('name')->get())
                    ];
                }
            }
        }
        $data['related_items'] = [];
        $products = Product::leftJoin('uploads', 'uploads.id', '=', 'products.thumbnail_img')
            ->join('product_translations', 'product_translations.product_id', '=', 'products.id')
            ->select(
                DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"),
                'products.id',
                'product_translations.name',
                'products.rating',
                'products.category_id',
                'products.unit_price',
                'products.quantity_1_price',
                'products.discount_start_date',
                'products.discount_end_date',
                'products.discount_type',
                'products.num_of_sale',
                'products.discount'
            )->whereNotIn('products.id', $skip_ids)->where('product_translations.lang', $locale)->limit(10)->get();
        foreach ($products as $product) {
            if ($product) {
                $home_discounted_base_price = home_discounted_base_price($product);
                $home_base_price = home_base_price($product);
                $data['related_items'][] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail_image' => $product->thumbnail_image,
                    'discount_price' => $home_discounted_base_price,
                    'base_price' => $home_base_price,
                    'has_discount' => ($home_base_price != $home_discounted_base_price),
                    'rating' => (float) $product->rating,
                    'sales' => (int) $product->num_of_sale,
                    'total_reviews' => 0,
                    'tyre_size' => '',
                    'brand_photo' => ''
                ];
            }
        }
        return response()->json(['result' => true, 'data' => $data], 200);
    }

    public function remove_cart_items(Request $request)
    {
        switch ($request->action) {
            case 'tyre_delete':
                DB::table('carts')->where('id', $request->cart_id)->where('user_id', $request->user_id)->delete();
                break;
            case 'tyres_delete':
                DB::table('carts')->where('package_id', '=', null)->where('user_id', $request->user_id)->delete();
                break;
            case 'package_delete':
                DB::table('carts')->where('id', $request->cart_id)->where('package_id', $request->package_id)->where('user_id', $request->user_id)->delete();
                DB::table('cart_package_products')->where('cart_id', $request->cart_id)->where('package_id', $request->package_id)->where('user_id', $request->user_id)->delete();
                break;
            case 'packages_delete':
                DB::table('carts')->where('package_id', '!=', null)->where('user_id', $request->user_id)->delete();
                DB::table('cart_package_products')->where('user_id', $request->user_id)->delete();
                break;
            case 'package_product':
                DB::table('cart_package_products')->where('product_id', $request->cart_id)->where('package_id', $request->package_id)->where('user_id', $request->user_id)->delete();
                if (DB::table('cart_package_products')->where('user_id', $request->user_id)->where('package_id', $request->package_id)->count() == 0) {
                    DB::table('carts')->where('user_id', $request->user_id)->where('package_id', $request->package_id)->delete();
                }
                break;
        }
        return response()->json(['data' => []], 200);
    }

    public function add(Request $request)
    {
        $user_type = DB::table('users')->where('id', $request->user_id)->select('user_type')->first()->user_type;
        if ($user_type == 'customer') {
            $product = Product::findOrFail($request->id);
            $tax = 0;
            $price = 0;
            $current_qty = 0;
            $stock = $product->qty;
            $cart = Cart::where('user_id', $request->user_id)->where('product_id', $request->id)->where('carlist_id', $request->carlist_id)->first();
            if ($cart) {
                $current_qty += $cart->quantity + $request->quantity;
                if ($current_qty == 1) {
                    $price = homeDiscountedBasePrice($product, $product->quantity_1_price);
                } else if ($current_qty == 2 || $current_qty == 3) {
                    $price = homeDiscountedBasePrice($product, $product->greater_1_price);
                } else if ($current_qty >= 4) {
                    $price = homeDiscountedBasePrice($product, $product->greater_3_price);
                }
            } else {
                $price = $request->total_price;
                $current_qty += $request->quantity;
            }

            if ($stock < $current_qty) {
                return response()->json(['result' => false, 'message' => "This item is reached to maximum limit in your cart!"], 200);
            }
            if ($product->min_qty > $current_qty) {
                return response()->json(['result' => false, 'message' => "Minimum {$product->min_qty} item(s) should be ordered"], 200);
            }
            if ($stock < $current_qty) {
                if ($stock == 0) {
                    return response()->json(['result' => false, 'message' => "Stock out"], 200);
                } else {
                    return response()->json(['result' => false, 'message' => "Only {$stock} item(s) are available for this product"], 200);
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

            if ($cart) {
                $cart->price = $price;
                $cart->tax = $tax;
                $cart->quantity += $request->quantity;
                $cart->update();
            } else {
                $cart = new Cart();
                $cart->user_id = $request->user_id;
                $cart->owner_id = $product->user_id;
                $cart->carlist_id = $request->carlist_id;
                $cart->product_id = $request->id;
                $cart->price = $price;
                $cart->tax = $tax;
                $cart->shipping_cost = 0;
                $cart->quantity = $request->quantity;
                $cart->save();
            }

            $total = 0;
            if ($request->user_id) {
                $cart = Cart::where('user_id', $request->user_id)->get();
                if (isset($cart) && count((is_countable($cart) ? $cart : [])) > 0) {
                    $total = count($cart);
                }
            }

            return response()->json([
                'result' => true,
                'product_id' => $request->id,
                'total_cart_items' => $total,
                'message' => 'Product added to cart successfully'
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Sorry! Product just can be buy by customer'
            ]);
        }
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart != null) {

            if ($cart->product->qty >= $request->quantity) {
                $cart->update([
                    'quantity' => $request->quantity
                ]);

                return response()->json(['result' => true, 'message' => 'Cart updated'], 200);
            } else {
                return response()->json(['result' => false, 'message' => 'Maximum available quantity reached'], 200);
            }
        }

        return response()->json(['result' => false, 'message' => 'Something went wrong'], 200);
    }

    public function get_shipping_info(Request $request, $radius = 25)
    {
        $carts_ids = explode(',', $request->ids);
        if (count($carts_ids)) {
            // update is_checkout status to 0 for current user so no product is selected for checkout
            DB::table('carts')->where('user_id', $request->user_id)->update(['is_checkout' => 0]);
            $car = DB::table('car_lists')->select('car_plate', 'brand_id', 'model_id', 'year_id', 'variant_id')->where('id', $request->carlist_id)->first();
            if ($car) {
                if (!$car->car_plate) {
                    return response()->json([
                        'result' => false,
                        'message' => 'Please add car plate for this list from your dashboard first.'
                    ], 400);
                }
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'Please select a vehicle first.'
                ], 400);
            }
            // update is_checkout for this record so we can get this cart record in checkout
            DB::table('carts')->whereIn('id', $carts_ids)->update(['is_checkout' => 1]);
            $carts = DB::table('carts')->select('id', 'package_id', 'product_id', 'battery_id', 'quantity')->where('user_id', $request->user_id)->whereIn('id', $carts_ids)->get();
            foreach ($carts as $cart) {
                if ($cart->product_id) {
                    $product = Product::select('brand_id', 'model_id', 'variant_id', 'year_id', 'id', 'quantity_1_price', 'greater_1_price', 'greater_3_price', 'category_id', 'discount_start_date', 'discount_end_date', 'discount_type', 'discount')->where('id', $cart->product_id)->first();
                    if ($product) {
                        // update quantity if greater than cart quantity
                        if ($request->has('tyre_quantity_' . $cart->id) && (request('tyre_quantity_' . $cart->id) != $cart->quantity)) {
                            $tyre_qty = request('tyre_quantity_' . $cart->id);
                            if ($tyre_qty == 1) {
                                $price = homeDiscountedBasePrice($product, $product->quantity_1_price);
                            } else if ($tyre_qty == 2 || $tyre_qty == 3) {
                                $price = homeDiscountedBasePrice($product, $product->greater_1_price);
                            } else if ($tyre_qty >= 4) {
                                $price = homeDiscountedBasePrice($product, $product->greater_3_price);
                            }
                            DB::table('carts')->where('id', $cart->id)->update([
                                'quantity' => $tyre_qty,
                                'price' => $price
                            ]);
                        }
                    }
                } elseif ($cart->package_id) {
                    $package = DB::table('packages')->select('brand_id', 'model_id', 'variant_id', 'year_id')->where('id', $cart->package_id)->first();
                    if ($package) {
                        // check package brands
                        $response = $this->check_selected_brand_in_brand_list('package', $car->brand_id, $package->brand_id);
                        if (isset($response['result']) && $response['result'] == false) {
                            return response()->json($response);
                        }
                        // check package models
                        $response = $this->check_selected_model_in_model_list('package', $car->model_id, $package->model_id);
                        if (isset($response['result']) && $response['result'] == false) {
                            return response()->json($response);
                        }
                        // check package years
                        if ($car->year_id) {
                            $response = $this->check_selected_year_in_years_list('package', $car->year_id, $package->year_id);
                            if (isset($response['result']) && $response['result'] == false) {
                                return response()->json($response);
                            }
                        }
                        // check package variants
                        if ($car->variant_id) {
                            $response = $this->check_selected_variant_in_variants_list('package', $car->variant_id, $package->variant_id);
                            if (isset($response['result']) && $response['result'] == false) {
                                return response()->json($response);
                            }
                        }
                    }
                } elseif ($cart->battery_id) {
                    $product = Battery::select('batteries.name', 'car_brand_id', 'car_model_id', 'stock', 'amount', 'sub_category_id', 'sub_child_category_id')->where('id', $cart->battery_id)->first();
                    if ($product) {
                        // update quantity if greater than cart quantity
                        if ($request->has('battery_quantity_' . $cart->id) && (request('battery_quantity_' . $cart->id) != $cart->quantity)) {
                            $battery_qty = request('battery_quantity_' . $cart->id);
                            $price = $product->amount * $battery_qty;
                            DB::table('carts')->where('id', $cart->id)->update([
                                'quantity' => $battery_qty,
                                'price' => $price
                            ]);
                        }
                    }
                }
            }
            return response()->json(['result' => true,], 200);
        } else {
            return response()->json(['result' => false, 'message' => 'Please select any tyre or package, to continue to checkout'], 200);
        }
    }

    // brands and models names string
    public function make_brand_model_string($datas)
    {
        $names = '';
        $i = 1;
        foreach ($datas as $data) {
            if ($i == 1) {
                $names .= $data->name;
            } else {
                $names .= ', ' . $data->name;
            }
            $i++;
        }
        return $names;
    }

    // check if the selected brand is present in product brands
    public function check_selected_brand_in_brand_list($type, $brand_id, $json)
    {
        if ($json != 'null') {
            if ($type == 'package') {
                $array[] = $json;
            } else {
                $array = json_decode($json);
            }
            if (!in_array($brand_id, $array)) {
                $brands = DB::table('brands')->whereIn('id', $array)->select('name')->get()->toArray();
                $brand_names = '';
                $i = 1;
                foreach ($brands as $brand) {
                    if ($i == 1) {
                        $brand_names .= $brand->name;
                        $i++;
                    } else {
                        $brand_names .= ', ' . $brand->name;
                    }
                }
                return [
                    'result' => false,
                    'message' => 'Please choose related brand for this ' . $type . ', related brands are: ' . $brand_names
                ];
            } elseif (in_array($brand_id, $array)) {
                return [
                    'result' => true,
                    'message' => 'Success'
                ];
            }
        }
    }

    // check if the selected model is present in product models
    public function check_selected_model_in_model_list($type, $model_id, $json)
    {
        if ($json != 'null') {
            if ($type == 'package') {
                $array[] = $json;
            } else {
                $array = json_decode($json);
            }
            if (!in_array($model_id, $array)) {
                $models = DB::table('car_models')->whereIn('id', $array)->select('name')->get()->toArray();
                $model_names = '';
                $i = 1;
                foreach ($models as $model) {
                    if ($i == 1) {
                        $model_names .= $model->name;
                    } else {
                        $model_names .= ', ' . $model->name;
                    }
                    $i++;
                }
                return [
                    'result' => false,
                    'message' => 'Please choose related model for this ' . $type . ', related models are: ' . $model_names
                ];
            } elseif (in_array($model_id, $array)) {
                return [
                    'result' => true,
                    'message' => 'Success'
                ];
            }
        }
    }

    // check if the selected detail is present in product details
    public function check_selected_year_in_years_list($type, $year_id, $json)
    {
        if ($json != 'null') {
            if ($type == 'package') {
                $array[] = $json;
            } else {
                $array = json_decode($json);
            }
            if (!in_array($year_id, $array)) {
                $years = DB::table('car_years')->whereIn('id', $array)->select('name')->get()->toArray();
                $year_names = '';
                $i = 1;
                foreach ($years as $year) {
                    if ($i == 1) {
                        $year_names .= $year->name;
                    } else {
                        $year_names .= ', ' . $year->name;
                    }
                    $i++;
                }
                return [
                    'result' => false,
                    'message' => 'Please choose related year for this ' . $type . ', related years are: ' . $year_names
                ];
            } elseif (in_array($year_id, $array)) {
                return [
                    'result' => true,
                    'message' => 'Success'
                ];
            }
        }
    }

    // check if the selected detail is present in product details
    public function check_selected_variant_in_variants_list($type, $variant_id, $json)
    {
        if ($json != 'null') {
            if ($type == 'package') {
                $array[] = $json;
            } else {
                $array = json_decode($json);
            }
            if (!in_array($variant_id, $array)) {
                $variants = DB::table('car_variants')->whereIn('id', $array)->select('name')->get()->toArray();
                $variant_names = '';
                $i = 1;
                foreach ($variants as $variant) {
                    if ($i == 1) {
                        $variant_names .= $variant->name;
                    } else {
                        $variant_names .= ', ' . $variant->name;
                    }
                    $i++;
                }
                return [
                    'result' => false,
                    'message' => 'Please choose related variant for this ' . $type . ', related variants are: ' . $variant_names
                ];
            } elseif (in_array($variant_id, $array)) {
                return [
                    'result' => true,
                    'message' => 'Success'
                ];
            }
        }
    }

    public function setGeolocation(Request $request)
    {
        $geolocation = new \stdClass();
        $geolocation->address = $request->address;
        $geolocation->latitude = $request->latitude;
        $geolocation->longitude = $request->longitude;
        $radius = $request->radius;
        if (empty($radius) && $radius == '') $radius = 25;
        $tyre_present = false;
        $services_present = false;
        if ($request->tyre == 'yes') {
            $tyre_present = true;
        }
        if ($request->services == 'yes') {
            $services_present = true;
        }
        $sellers = $this->getNearbyVendors($radius, $geolocation->address, $geolocation->latitude, $geolocation->longitude, $tyre_present, $services_present);

        $vendors = collect($sellers);
        $shops_arr = $vendors->map(function ($vendor) {
            $seller = Seller::find($vendor->id);
            $shop = $seller->user->shop;
            return [
                'shop_id' => $shop->id,
                'shop_name' => $shop->name,
                'address' => $shop->address,
                'rating' => $shop->rating,
                'distance' => number_format($vendor->distance, 1) . ' KM',
                'latitude' => $vendor->latitude,
                'longitude' => $vendor->longitude
            ];
        });

        return response()->json([
            'result' => true,
            'shops_count' => count($sellers),
            'shops' => $shops_arr,
        ], 200);
    }

    public function checkTimings(Request $request)
    {
        $current_date = date('Y-m-d', strtotime('+3 days'));
        $available_dates = WorkshopAvailability::select('shop_id', 'date')->where('shop_id', $request->shop_id)->where('from_time', '!=', '')->where('to_time', '!=', '')->whereDate('date', '>=', $current_date)->get();
        if (count($available_dates) > 0) {
            $dates_arr = $available_dates->map(function ($data) {
                $message = '';
                $time_array = [];
                $shop = WorkshopAvailability::where('shop_id', $data->shop_id)->where('date', '=', $data->date)->first();
                if ($shop && $shop->from_time && $shop->to_time) {
                    $shop_details = Shop::where('id', $data->shop_id)->select('availability_duration')->first();
                    $from_time = $shop->from_time;
                    $to_time = $shop->to_time;
                    $diff = abs(strtotime($from_time) - strtotime($to_time));
                    // Convert $diff to minutes
                    $tmins = $diff / 60;
                    // Get hours
                    $duration = ($shop_details->availability_duration) ? $shop_details->availability_duration : 60;
                    $total_appointments = round(floor($tmins / $duration));
                    if ($shop->booked_appointments < $total_appointments) {
                        $from_time = $shop->date . ' ' . $from_time;
                        for ($i = 0; $i < $total_appointments; $i++) {
                            $order = DB::table('orders')->where('availability_id', $shop->id)->whereDate('workshop_date', date('Y-m-d', strtotime($from_time)))->whereTime('workshop_time', date('h:i A', strtotime($from_time)))->first();
                            if (!$order) {
                                array_push($time_array, date('g:i A', strtotime($from_time)));
                            }
                            $from_time = strtotime($from_time . ' + ' . $duration . ' minute');
                            $from_time = date('Y-m-d H:i:00', $from_time);
                        }
                        $message = 'ok';
                    } else {
                        $message = 'Slots are already booked on this date for this workshop. Please select another date.';
                    }
                } else {
                    $message = 'Workshop is not available on this date. Please select another date.';
                }

                return [
                    'date' => $data->date,
                    'availability_id' => $shop->id,
                    'time_message' => $message,
                    'date_timings' => $time_array,
                ];
            });
            return response()->json([
                'result' => true,
                'dates' => $dates_arr,
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No available dates found.',
            ], 200);
        }
    }

    private function getNearbyVendors($radius, $address, $latitude, $longitude, $tyre_present, $services_present)
    {
        $vendors = array();
        if ($address && $latitude && $longitude) {
            if ($latitude != 0 && $longitude != 0) {
                $datas = User::join('sellers', 'users.id', '=', 'sellers.user_id')
                    ->join('shops', 'users.id', '=', 'shops.user_id')
                    ->where('users.user_type', '=', 'seller')
                    ->select('shops.latitude', 'shops.longitude', 'sellers.id', 'shops.category_id');
                $datas = $datas->orderBy('id', 'desc')->get();
                foreach ($datas as $data) {
                    $shop_categories = ($data->category_id) ? json_decode($data->category_id, true) : [];
                    if ($tyre_present && $services_present) {
                        if (!in_array(1, $shop_categories) && !in_array(4, $shop_categories)) {
                            continue;
                        }
                    }
                    if ($tyre_present) {
                        if (!in_array(1, $shop_categories)) {
                            continue;
                        }
                    }
                    if ($services_present) {
                        if (!in_array(4, $shop_categories)) {
                            continue;
                        }
                    }
                    $distance = distance($data->latitude, $data->longitude, $latitude, $longitude, 'K');
                    if ($distance <= 50) {
                        $data->distance = $distance;
                        if ($distance <= $radius) {
                            $vendors[] = $data;
                        }
                    }
                }
            }
        }
        return $vendors;
    }

    public function destroy($id)
    {
        Cart::destroy($id);
        return response()->json(['result' => true, 'message' => 'Product is successfully removed from your cart'], 200);
    }

    public function removeAll(Request $request)
    {
        $products = explode(',', $request->products);
        foreach ($products as $product) {
            Cart::where('product_id', $product)->delete();
        }
        return response()->json(['result' => true, 'message' => 'Product Items removed successfully from your cart'], 200);
    }

    public function tyrePageData(Request $request, $category_id, $user_id = null)
    {
        $featured_category_id = $request->featured_category_id;
        $featured_sub_category_id = $request->featured_sub_category_id;
        $vehicle_category_id = $request->vehicle_category_id;
        if ($category_id != null && $category_id == 1) {
            return $this->search($request, $category_id, $featured_category_id, $featured_sub_category_id, $vehicle_category_id, $user_id);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'No category found!',
            ], 404);
        }
    }

    public function search(Request $request, $category_id = null, $featured_id = null, $sub_featured_id = null, $vehicle_category_id = null, $user_id)
    {
        $sort_by = $request->sort_by;
        $brand_filter = $request->filter_by_brand;
        $front_rear_filter = $request->filter_by_front_rear;
        $product_filter = $request->filter_by_products;
        $featured_categories = FeaturedCategory::select('id', 'name')->get();
        $vehicle_categories = VehicleCategory::select('id', 'name')->get();
        $size_categories = SizeCategory::select('id', 'name')->orderBy('name','desc')->get();
        $brands = Brand::orderBy('name','asc')->select('id', 'name')->get();
        $tyre_brands = DB::table('brand_datas')->where('type','tyre_brands')->select('id', 'name')->get();

        $lists_arr = [];
        if ($user_id) {
            $lists = DB::table('car_lists')
                ->leftJoin('brands', 'brands.id', '=', 'car_lists.brand_id')
                ->leftJoin('car_models', 'car_models.id', '=', 'car_lists.model_id')
                ->leftJoin('car_years', 'car_years.id', '=', 'car_lists.year_id')
                ->leftJoin('car_variants', 'car_variants.id', '=', 'car_lists.variant_id')
                ->select('brands.name as brand_name', 'car_models.name as model_name', 'car_years.name as year_name',
                'car_variants.name as variant_name', 'car_lists.brand_id', 'car_lists.model_id', 'car_lists.year_id', 'car_lists.variant_id',
                'car_lists.car_plate', 'car_lists.id')
                ->where('car_lists.user_id', $user_id)
                ->orderBy('car_lists.id', 'desc')
                ->get();    
            $lists_arr = $lists->map(function ($list) {
                return [
                    'id' => $list->id,
                    'car_plate' => $list->car_plate,
                    'brand_id' => $list->brand_id ? $list->brand_id : 0,
                    'model_id' => $list->model_id ? $list->model_id : 0,
                    'year_id' => $list->year_id ? $list->year_id : 0,
                    'variant_id' => $list->variant_id ? $list->variant_id : 0,
                    'brand_name' => $list->brand_name,
                    'model_name' => $list->model_name,
                    'year_name' => $list->year_name,
                    'variant_name' => $list->variant_name,
                    'image' => ''
                ];
            });
        }
        $featured_categories_arr = $featured_categories->map(function ($featured_category) {
            $featured_sub_categories = FeaturedSubCategory::where('featured_category_id', $featured_category->id)->select('id', 'name')->get();
            $featured_sub_categories_arr = $featured_sub_categories->map(function ($featured_sub_category) {
                return [
                    'id' => $featured_sub_category->id,
                    'name' => $featured_sub_category->name,
                ];
            });
            return [
                'id' => $featured_category->id,
                'name' => $featured_category->name,
                'featured_sub_categories_arr' => $featured_sub_categories_arr
            ];
        });
        $vehicle_categories_arr = $vehicle_categories->map(function ($vehicle_category) {
            return [
                'id' => $vehicle_category->id,
                'name' => $vehicle_category->name,
            ];
        });

        $brand_id = $request->brand_id ? $request->brand_id : '';
        $model_id = $request->model_id ? $request->model_id : '';
        $year_id = $request->year_id ? $request->year_id : '';
        $variant_id = $request->variant_id ? $request->variant_id : '';

        $size_alternatives = '';
        if ($model_id) {
            $size_alternatives = DB::table('size_alternatives')->where('model_id', $model_id)->select('name')->orderBy('name', 'desc')->get()->toArray();
        }
        $brand = Brand::where('id', $brand_id)->select('name')->first();
        $model = CarModel::where('id', $model_id)->select('name')->first();
        $year = CarYear::where('id', $year_id)->select('name')->first();
        $variant = CarVariant::where('id', $variant_id)->select('name')->first();

        $your_vehicle = '';
        if ($brand) {
            $your_vehicle .= $brand->name;
        }
        if ($model) {
            $your_vehicle .= ', ' . $model->name;
        }
        if ($year) {
            $your_vehicle .= ', ' . $year->name;
        }
        if ($variant) {
            $your_vehicle .= ', ' . $variant->name;
        }
        $size_cat_id = '';
        $sub_cat_id = '';
        $child_cat_id = '';
        $products = Product::where('category_id', $category_id)
        ->when(!empty($request->brand_id), function ($q) {
            return $q->whereJsonContains('brand_id', request('brand_id'));
        })
        ->when(!empty($request->model_id), function ($q) {
            return $q->whereJsonContains('model_id', request('model_id'));
        })
        ->when(!empty($request->year_id), function ($q) {
            return $q->whereJsonContains('year_id', request('year_id'));
        })
        ->when(!empty($request->variant_id), function ($q) {
            return $q->whereJsonContains('variant_id', request('variant_id'));
        });
        if ($request->size_cat_id) {
            $size_cat_id = $request->size_cat_id;
            $products = $products->where('size_category_id', $request->size_cat_id);
        }
        if ($request->sub_cat_id) {
            $sub_cat_id = $request->sub_cat_id;
            $products = $products->where('size_sub_category_id', $request->sub_cat_id);
        }
        if ($request->child_cat_id) {
            $child_cat_id = $request->child_cat_id;
            $products = $products->where('size_child_category_id', $request->child_cat_id);
        }
        if ($brand_filter != null) {
            $products = $products->where('name', 'like', '%' . $brand_filter . '%');
        }
        if ($front_rear_filter != null) {
            $products = $products->where('front_rear', $front_rear_filter);
        }
        if ($product_filter != null) {
            $products = $products->where('featured_sub_cat_id', $product_filter);
        }
        if ($featured_id != null) {
            $products = $products->where('featured_cat_id', $featured_id);
        }
        if ($sub_featured_id != null) {
            $products = $products->where('featured_sub_cat_id', $sub_featured_id);
        }
        if ($vehicle_category_id != null) {
            $products = $products->where('vehicle_cat_id', $vehicle_category_id);
        }

        switch ($sort_by) {
            case 'oldest':
                $products->orderBy('created_at', 'asc');
                break;
            case 'price-asc':
                $products->orderBy('quantity_1_price', 'asc');
                break;
            case 'tyre-brand':
                $products->orderByRaw("FIELD(tyre_service_brand_id , $request->tyre_brand) desc");
                break;
            default:
                $products->orderBy('created_at', 'desc');
                break;
        }
        $products = filter_products($products)->paginate(10)->appends(request()->query());
        $products->getCollection()->transform(function ($product) {
            $brand_photo = DB::table('brand_datas')->where('id', $product->tyre_service_brand_id)->select('photo')->first();
            return [
                'id' => $product->id,
                'name' => $product->getTranslation('name'),
                'thumbnail_image' => ($product->thumbnail_img) ? api_asset($product->thumbnail_img) : static_asset('assets/img/tyre.png'),
                'discount_price' => home_discounted_base_price($product),
                'base_price' => home_base_price($product),
                'has_discount' => home_base_price($product) != home_discounted_base_price($product),
                'rating' => $product->rating,
                'sales' => (int) $product->num_of_sale,
                'total_reviews' => $product->reviews->count(),
                'tyre_size' => $product->tyre_size ? $product->tyre_size : '',
                'brand_photo' => $brand_photo ? api_asset($brand_photo->photo) : '',
            ];
        });
        $tyre_deals = Deal::where('type','tyre')->where('status', 1)->select('id' ,'start_date', 'end_date', 'text_color', 'banner')->get();
        $tyre_deals = $tyre_deals->map(function($deal){
             return[
                'id' => $deal->id,
                'title' => $deal->getTranslation('title'),
                'text_color' => $deal->text_color,
                'banner' => api_asset($deal->banner),
             ];
        });
        return response()->json([
            'result' => true,
            'products' => $products,
            'category_id' => $category_id,
            'sort_by' => $sort_by ? $sort_by : '',
            'brand_id' => $brand_id,
            'model_id' => $model_id,
            'year_id' => $year_id,
            'variant_id' => $variant_id,
            'your_vehicle' => $your_vehicle,
            'featured_filters' => $featured_categories,
            'featured_sub_filters' => FeaturedSubCategory::all(),
            'lists' => $lists_arr,
            'size_categories' => $size_categories,
            'brands' => $brands,
            'featured_categories_arr' => $featured_categories_arr,
            'vehicle_categories' => $vehicle_categories_arr,
            'size_alternatives' => $size_alternatives,
            'size_cat_id' => $size_cat_id,
            'sub_cat_id' => $sub_cat_id,
            'child_cat_id' => $child_cat_id,
            'tyre_brands' => $tyre_brands,
            'tyre_deals' => $tyre_deals
        ], 200);
    }

    public function getSizeSubCats($size_cat_id)
    {
        $datas = SizeSubCategory::where('size_category_id', $size_cat_id)->orderBy('name','desc')->get();
        $datas_arr = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        return response()->json([
            'result' => true,
            'data' => $datas_arr,
        ], 200);
    }

    public function getSizeChildCats($cat_id)
    {
        $datas = SizeChildCategory::where('size_sub_category_id', $cat_id)->orderBy('name','desc')->get();
        $datas_arr = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        return response()->json([
            'result' => true,
            'data' => $datas_arr,
        ], 200);
    }

    public function getModels($brand_id)
    {
        $models = CarModel::where('brand_id', $brand_id)->orderBy('name', 'asc')->get();
        $datas_arr = $models->map(function ($model) {
            return [
                'id' => $model->id,
                'name' => $model->name
            ];
        });
        return response()->json([
            'result' => true,
            'data' => $datas_arr,
        ], 200);
    }

    public function getYears($model_id)
    {
        $datas = CarYear::where('model_id', $model_id)->orderBy('name', 'asc')->get();
        $vehicle_sizes = VehicleSize::where('model_id', $model_id)->orderBy('name', 'desc')->get();
        $size_alternatives = SizeAlternative::where('model_id', $model_id)->orderBy('name', 'desc')->get();

        $datas_arr = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        $vehicle_size = $vehicle_sizes->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        $size_alternatives = $size_alternatives->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        return response()->json([
            'result' => true,
            'data' => $datas_arr,
            'vehicle_size' => $vehicle_size,
            'size_alternatives' => $size_alternatives
        ], 200);
    }

    public function getVariants($year_id)
    {
        $datas = CarVariant::where('year_id', $year_id)->orderBy('name', 'asc')->get();
        $datas_arr = $datas->map(function ($data) {
            return [
                'id' => $data->id,
                'name' => $data->name
            ];
        });
        return response()->json([
            'result' => true,
            'data' => $datas_arr,
        ], 200);
    }
}
