<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartPackageProduct;
use App\Models\Deal;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    public function services_page(Request $request)
    {
        $service_deals = Deal::where('type', 'service')
            ->select('id', 'start_date', 'end_date', 'text_color', 'banner')
            ->where('status', 1)
            ->get();

        $service_deals = $service_deals->map(function ($deal) {
            return [
                'id' => $deal->id,
                'title' => $deal->getTranslation('title'),
                'text_color' => $deal->text_color,
                'banner' => api_asset($deal->banner),
            ];
        });

        $active_car = DB::table('car_lists')->where('id', $request->car_id)->select('mileage')->first();
        return response()->json([
            'result' => true,
            'service_deals' => $service_deals,
            'current_mileage' => $active_car->mileage
        ], 200);
    }

    public function all_services(Request $request)
    {
        $mileage = request('mileage');
        $services = $this->get_packages_on_mileage($mileage, $request);
        $iteration = 0;
        while (count($services) == 0 && $iteration < 5) {
            $mileage += 5000;
            $services = $this->get_packages_on_mileage($mileage, $request);
            $iteration++;
        }

        $data['mileage'] = $mileage;
        $data['services'] = [];
        foreach ($services as $service) {
            $added_category_sub_child = [];
            $pids = [];
            $quantities = [];
            $amount = 0;
            $pp = DB::table('package_products')->select('product_id', 'package_type', 'mileage', 'qty')->where('package_id', $service->id)->get()->toArray();
            if (count($pp)) {
                foreach ($pp as $prod) {
                    if ($prod->mileage && ($mileage % $prod->mileage === 0)) {
                        $pids[] = $prod->product_id;
                        $quantities[$prod->product_id] = $prod->qty;
                    } else if ($prod->package_type == request('package_type')) {
                        $pids[] = $prod->product_id;
                        $quantities[$prod->product_id] = $prod->qty;
                    }
                }

                $products = Product::select('id', 'category_id', 'unit_price', 'discount_start_date', 'discount_end_date', 'discount_type', 'discount', 'sub_category_id', 'sub_child_category_id')->whereIn('id', $pids)->get();
                if(count($products)){
                foreach ($products as $product) {
                    if (!(isset($added_category_sub_child[$product->sub_category_id]) && $added_category_sub_child[$product->sub_category_id] == $product->sub_child_category_id)) {
                        $amount += ($quantities[$product->id] * homeDiscountedBasePrice($product));
                        $added_category_sub_child[$product->sub_category_id] = $product->sub_child_category_id;
                    }
                }
                $data['services'][] =  [
                    'id' => $service->id,
                    'name' => 'Package',
                    'mileage' => 0,
                    'type' => '',
                    'expiry_date' => 'Carkee',
                    'expiry_month' => $service->expiry_month,
                    'attachment' => '',
                    'amount' => (string) (convert_price($amount))
                ];
              }
            }

        }
        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function get_packages_on_mileage($mileage, $request)
    {
        return DB::table('packages')
            ->select('id', 'expiry_month')
            ->when(!empty($request->brand_id), function ($q) {
                return $q->where('brand_id', (string) request('brand_id'));
            })
            ->when(!empty($request->model_id), function ($q) {
                return $q->where('model_id', (string) request('model_id'));
            })
            ->when(!empty($request->year_id), function ($q) {
                return $q->where('year_id', (string) request('year_id'));
            })
            ->when(!empty($request->variant_id), function ($q) {
                return $q->where('variant_id', (string) request('variant_id'));
            })
            ->whereJsonContains('mileages', (string) $mileage)
            ->get();
    }

    public function services_package_products(Request $request)
    {   
        $symbol = DB::table('currencies')
            ->select('symbol')
            ->where('id', get_setting('system_default_currency'))
            ->first()->symbol;

        $pp = DB::table('package_products')
            ->select('product_id', 'package_type', 'type', 'mileage', 'qty')
            ->where('package_id', $request->package_id)
            ->get()
            ->toArray();

        $amount = 0;
        $pids = [];
        $quantities = [];
        $p_types = [];
        $data['services']['Recommended'] = [];
        $data['services']['Addon'] = [];

        foreach ($pp as $prod) {
            if ($prod->mileage && (request('mileage') % $prod->mileage === 0)) {
                $pids[] = $prod->product_id;
                $quantities[$prod->product_id] = $prod->qty;
                $p_types[$prod->product_id] = ($prod->type == 'R' ? 'Recommended' : 'Addon');
            } else if ($prod->package_type == request('package_type')) {
                $pids[] = $prod->product_id;
                $quantities[$prod->product_id] = $prod->qty;
                $p_types[$prod->product_id] = ($prod->type == 'R' ? 'Recommended' : 'Addon');
            }
        }

        $products = Product::leftJoin('uploads', 'uploads.id', 'products.thumbnail_img')
            ->select('products.id', 'products.name', 'products.category_id', 'products.tyre_size', 'products.user_id', 'products.ps_status', 'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount', 'products.discount_type', 'products.sub_category_id', 'products.sub_child_category_id', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"))
            ->where('products.published', 1)
            ->whereIn('products.id', $pids)
            ->get();

        $added_category_sub_child = [];
        $group_category_sub_child = [];
        foreach ($products as $key => $product) {
            if (!(isset($added_category_sub_child[$product->sub_category_id]) && $added_category_sub_child[$product->sub_category_id] == $product->sub_child_category_id)) {
                $added_category_sub_child[$product->sub_category_id] = $product->sub_child_category_id;
                $price = $quantities[$product->id] * homeDiscountedBasePrice($product);
                $amount += $price;
                $data['services'][$p_types[$product->id]][] = array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'tyre_size' => $product->tyre_size,
                    'ps_status' => $product->ps_status,
                    'attachment' => $product->attachment,
                    'price' => (string) convert_price($price),
                    'currency_symbol' => $symbol,
                    'quantity' => (string) $quantities[$product->id] ?? 1,
                    'group_id' => false,
                    'sub_category_id' => $product->sub_category_id,
                    'sub_child_category_id' => $product->sub_child_category_id,
                );
            } else {
                $group_category_sub_child[$product->sub_category_id] = $product->sub_child_category_id;
            }
            foreach ($data['services'] as $type => $products) {
                foreach ($products as $key => $product) {
                    if (isset($group_category_sub_child[$product['sub_category_id']]) && $group_category_sub_child[$product['sub_category_id']] == $product['sub_child_category_id']) {
                        $data['services'][$type][$key]['group_id'] = true;
                    }
                }
            }
        }

        $data['package'] = array(
            'id' => $request->package_id,
            'name' => 'Package',
            'attachment' => '',
            'amount' => (string) convert_price($amount),
        );
        return response()->json(['result' => true, 'data' => $data], 200);
    }

    public function service_package_overview(Request $request)
    {
        $package_product = DB::table('packages')
            ->select('id', 'expiry_month', 'description')
            ->where('packages.id', $request->package_id)
            ->first();

        $amount = 0;
        $pids = [];
        $quantities = [];
        $pp = DB::table('package_products')
            ->select('product_id', 'package_type', 'mileage', 'qty')
            ->where('package_id', $request->package_id)
            ->get()
            ->toArray();

        foreach ($pp as $prod) {
            $pids[] = $prod->product_id;
            $quantities[$prod->product_id] = $prod->qty;
        }

        $products = Product::select('id', 'category_id', 'unit_price', 'discount_start_date', 'discount_end_date', 'discount_type', 'discount')
            ->whereIn('id', $pids)
            ->get();

        foreach ($products as $product) {
            $amount += ($quantities[$product->id] * homeDiscountedBasePrice($product));
        }

        $data['package'] = array(
            'id' => $package_product->id,
            'name' => 'Package',
            'mileage' => 0,
            'type' => '',
            'expiry_month' => $package_product->expiry_month,
            'attachment' => '',
            'description' => $package_product->description,
            'amount' => number_format(convert_price($amount), 2)
        );

        $data['reviews'] = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.name', 'reviews.rating', 'reviews.comment')
            ->where('reviews.package_id', $package_product->id)
            ->get()
            ->toArray();

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function services_package_product_group(Request $request)
    {
        $symbol = DB::table('currencies')
            ->select('symbol')
            ->where('id', get_setting('system_default_currency'))
            ->first()->symbol;

        $pp = DB::table('package_products')
            ->select('product_id', 'package_type', 'mileage', 'qty')
            ->where('package_id', $request->package_id)
            ->get()
            ->toArray();

        $pids = [];
        $quantities = [];
        foreach ($pp as $prod) {
            $pids[] = $prod->product_id;
            $quantities[$prod->product_id] = $prod->qty;
        }

        $products = DB::table('products')
            ->select('id', 'sub_category_id', 'sub_child_category_id')
            ->where('products.published', 1)
            ->whereIn('products.id', $pids)
            ->get()
            ->toArray();
        $pids = [];
        $service_products['products'] = [];
        foreach ($products as $product) {
            // $product->sub_category_id == $request->sub_category_id && 
            if ($product->sub_child_category_id == $request->sub_child_category_id && $product->id != $request->product_id) {
                $pids[] = $product->id;
            }
        }

        $products = Product::leftJoin('uploads', 'uploads.id', 'products.thumbnail_img')
            ->select('products.id', 'products.name', 'products.category_id', 'products.tyre_size', 'products.user_id', 'products.ps_status', 'products.unit_price', 'products.discount_start_date', 'products.discount_end_date', 'products.discount', 'products.discount_type', 'products.sub_category_id', 'products.sub_child_category_id', DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS attachment"))
            ->where('products.published', 1)
            ->whereIn('products.id', $pids)
            ->get();
        foreach ($products as $product) {
            $service_products['products'][] = array(
                'id' => $product->id,
                'name' => $product->name,
                'tyre_size' => $product->tyre_size,
                'ps_status' => $product->ps_status,
                'attachment' => $product->attachment,
                'price' => (string) (convert_price($quantities[$product->id] * homeDiscountedBasePrice($product))),
                'currency_symbol' => $symbol,
                'quantity' => (string) $quantities[$product->id] ?? 1,
                'group_id' => true,
                'sub_category_id' => $product->sub_category_id,
                'sub_child_category_id' => $product->sub_child_category_id,
            );
        }
        return response()->json(['result' => true, 'data' => $service_products], 200);
    }

    public function services_package_add_to_cart(Request $request)
    {
        $user_type = DB::table('users')->where('id', $request->user_id)->select('user_type')->first()->user_type;
        if ($user_type == 'customer') {
            if (!DB::table('carts')->where('user_id', $request->user_id)->where('package_id', $request->package_id)->first()) {
                // Cart
                $cart = new Cart();
                $cart->carlist_id = $request->carlist_id;
                $cart->user_id = $request->user_id;
                $cart->package_id = $request->package_id;
                $cart->save();
                $price = 0;
                $tax = 0;
                $shipping_cost = 0;
                $products = $request->products;

                // Cart Package Products
                foreach ($products as $cpp) {
                    $cart_package = new CartPackageProduct();
                    $cart_package->cart_id = $cart->id;
                    $cart_package->product_id = $cpp['product_id'];
                    $cart_package->package_id = $request->package_id;
                    $cart_package->user_id = $request->user_id;
                    $cart_package->type = $cpp['type'];
                    $cart_package->price = $cpp['price'];
                    $cart_package->tax = $cpp['tax'];
                    $cart_package->shipping_cost = $cpp['shipping_cost'];
                    $cart_package->discount = $cpp['discount'];
                    $cart_package->quantity = $cpp['quantity'];
                    $cart_package->ps_status = $cpp['ps_status'];
                    $cart_package->save();

                    $price += ($cpp['price'] - ($cpp['shipping_cost'] + $cpp['tax'] + $cpp['discount']));
                    $tax += $cpp['tax'];
                    $shipping_cost += $cpp['shipping_cost'];
                }

                $cart->price = $price;
                $cart->tax = $tax;
                $cart->shipping_cost = $shipping_cost;
                $cart->update();
                return response()->json(['result' => true, 'message' => translate('Cart Updated Successfully')], 200);
            } else {
                return response()->json(['result' => true, 'message' => translate('Package already added to cart')], 200);
            }
        } else {
            return response()->json(['result' => false, 'message' => translate('Sorry! Product just can be buy by customer')], 200);
        }
    }
}
