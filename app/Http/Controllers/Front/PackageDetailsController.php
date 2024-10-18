<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackageDetailsController extends Controller
{
    public function details(Request $request, $id)
    {
        $package = Package::where('id', $id)->first();
        $aproducts = [];
        $ppr = PackageProduct::where('package_id', $id)->where('type', 'Recommended')->first();
        $ppa = PackageProduct::where('package_id', $id)->where('type', 'Addon')->first();

        ////
        if (isset($ppr)) {
            $cart_package_product_r = DB::table('cart_package_products')->where('product_id', $ppr->id)->where('user_id', Auth::id())->first();
        }
        if (isset($ppa)) {
            $cart_package_product_a = DB::table('cart_package_products')->where('product_id', $ppa->id)->where('user_id', Auth::id())->first();
        }
        if (isset($cart_package_product_r)) {
            $pppr = DB::table('cart_package_products')->where('product_id', $ppr->id)->where('user_id', Auth::id())->first();
        }
        if (isset($cart_package_product_a)) {
            $pppa = DB::table('cart_package_products')->where('product_id', $ppa->id)->where('user_id', Auth::id())->first();
        }


        if (isset($pppr)) {

            $rproducts = json_decode(!empty($pppr->products) ? $pppr->products : '', TRUE);
        } else {

            $rproducts = json_decode(!empty($ppr->products) ? $ppr->products : '', TRUE);
        }
        if (isset($pppa)) {
            $aproducts = json_decode($pppa->products, TRUE);
        } else {

            $aproducts = json_decode(isset($ppa) ? $ppa->products : '', TRUE);
        }

        ////Recommended part
        if (isset($rproducts)) {
            $numbers = $rproducts;
            if ($request->old_id && $numbers) {
                if (($key = array_search($request->old_id, $numbers)) !== false) {
                    unset($numbers[$key]);
                    $numbers[$key] = $request->new_id;
                    $numbers = array_values($numbers);
                }
                $rproducts = $numbers;
            }
        }
        //////Addon Part

        $anumbers = $aproducts;
        if ($request->old_id && $anumbers) {
            if (($akey = array_search($request->old_id, $anumbers)) !== false) {
                unset($anumbers[$akey]);
                $anumbers[$akey] = $request->new_id;
                $anumbers = array_values($anumbers);
            }
            $aproducts = $anumbers;
        }

        //dd($aproducts);

        //////
        if (Auth::user()) {
            if (isset($ppr)) {
                if ($cart_package_product_r) {
                    DB::table('cart_package_products')->where('product_id', $ppr->id)->where('user_id', Auth::id())->update([
                        'user_id' => Auth::id(),
                        'products' => json_encode(array_unique($rproducts))
                    ]);
                } else {
                    DB::table('cart_package_products')->where('product_id', $ppr->id)->insert([
                        'product_id' => $ppr->id,
                        'package_id' => $ppr->package_id,
                        'user_id' => Auth::id(),
                        'products' => json_encode(array_unique($rproducts)),
                    ]);
                }
            }
            if (isset($ppa)) {
                if ($cart_package_product_a) {
                    //                return $ppa->id;
                    DB::table('cart_package_products')->where('product_id', $ppa->id)->where('user_id', Auth::id())->update([
                        'user_id' => Auth::id(),
                        'products' => json_encode(array_unique($aproducts))
                    ]);
                } else {
                    DB::table('cart_package_products')->where('product_id', $ppa->id)->insert([
                        'product_id' => $ppa->id,
                        'package_id' => $ppa->package_id,
                        'user_id' => Auth::id(),
                        'products' => json_encode(array_unique($aproducts)),
                        'type' => "Addon",
                    ]);
                }
            }
        } else {
            flash(translate('Please Login First!'))->error();
            return back();
        }

        ///
        //        $ppr->update([
        //          'products' => json_encode(array_unique($rproducts))
        //        ]);
        //        dd(json_encode($rproducts));

        return view('frontend.package_details', compact('package', 'aproducts', 'rproducts'));
    }
}
