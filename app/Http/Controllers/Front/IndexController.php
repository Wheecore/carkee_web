<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarDetail;
use App\Models\CarModel;
use App\Models\CarType;
use App\Models\Category;
use App\Models\Package;
use App\Models\PackageProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index()
    {
        Session::forget('cat_type');
        $brands = Brand::get();
        return  view('frontend.home', compact('brands'));
    }

    public function brandSubChildes(Request $request)
    {
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        if ($key_val == 1) {

            $brands = CarModel::where(['brand_id' => $request->id])->orderBy('id', 'ASC')->get();
        } else if ($key_val == 2) {

            $brands = CarDetail::where(['model_id' => $request->id])->orderBy('id', 'ASC')->get();
        } else {

            $brands = CarType::where(['details_id' => $request->id])->orderBy('id', 'ASC')->get();
        }

        if (count($brands) > 0) {
            return view('frontend.searching.brands', compact('count_value', 'key_val', 'category', 'brands'));
        } else {
            return 'empty';
        }
    }
    public function ajax_models(Request $request)
    {
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        $brand = Brand::where('id', $request->id)->first();
        $cat = Brand::where('name', $name)->first();
        if ($cat) {
            $category = CarModel::where(['brand_id' => $request->id])->get();
        }

        $models = CarModel::where(['brand_id' => $request->id])->get();
        if (count($models) > 0) {
            return view('frontend.ajax.get_models', compact('count_value', 'key_val', 'category', 'models', 'brand'));
        } else {
            return 'empty';
        }
    }
    public function ajax_p_models(Request $request)
    {
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        $brand = Brand::where('id', $request->id)->first();
        $cat = Brand::where('name', $name)->first();
        if ($cat) {
            $category = CarModel::where(['brand_id' => $request->id])->get();
        }

        $models = CarModel::where(['brand_id' => $request->id])->get();
        if (count($models) > 0) {
            return view('frontend.ajax.panic.get_models', compact('count_value', 'key_val', 'category', 'models', 'brand'));
        } else {
            return 'empty';
        }
    }
    public function ajax_car_details(Request $request)
    {
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        //
        $model = CarModel::where(['id' => $request->id])->first();
        $brand = Brand::where('id', $model->brand_id)->first();
        //

        $detail = CarDetail::where('model_id', $request->id)->first();
        $brand_id = $detail ? $detail->brand_id : '';
        $cat = Brand::where('name', $name)->first();
        if ($cat) {
            $category = CarModel::where(['brand_id' => $request->id])->get();
        }

        $details = CarDetail::where(['model_id' => $request->id])->get();
        if (count($details) > 0) {
            return view('frontend.ajax.get_car_details', compact('count_value', 'key_val', 'category', 'details', 'brand_id', 'model', 'brand'));
        } else {
            return 'empty';
        }
    }
    public function ajax_p_car_details(Request $request)
    {
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        //
        $model = CarModel::where(['id' => $request->id])->first();
        $brand = Brand::where('id', $model->brand_id)->first();
        //

        $detail = CarDetail::where('model_id', $request->id)->first();
        $brand_id = $detail ? $detail->brand_id : '';
        $cat = Brand::where('name', $name)->first();
        if ($cat) {
            $category = CarModel::where(['brand_id' => $request->id])->get();
        }

        $details = CarDetail::where(['model_id' => $request->id])->get();
        if (count($details) > 0) {
            return view('frontend.ajax.panic.get_car_details', compact('count_value', 'key_val', 'category', 'details', 'brand_id', 'model', 'brand'));
        } else {
            return 'empty';
        }
    }

    public function ajax_car_types(Request $request)
    {
        if ($request->itype) {
            $itype = 1 + $request->itype;
        } else {
            $itype = 1;
        }
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        $type = CarType::where('details_id', $request->id)->first();
        $model_id = $type ? $type->model_id : '';
        //
        $detail = CarDetail::where(['id' => $request->id])->first();

        $model = CarModel::where(['brand_id' => $detail ? $detail->brand_id : 0])->first();
        $brand = Brand::where('id', $detail ? $detail->brand_id : 0)->first();
        $types = CarType::where(['details_id' => $request->id])->get();
        if (count($types) > 0) {
            return view('frontend.ajax.get_car_types', compact('count_value', 'key_val', 'category', 'types', 'model_id', 'model', 'brand', 'detail', 'itype'));
        } else {
            return 'empty';
        }
    }
    public function ajax_p_car_types(Request $request)
    {
        if ($request->itype) {
            $itype = 1 + $request->itype;
        } else {
            $itype = 1;
        }
        $category = 0;
        $name = $request->name;
        $count_value = $request->count_value;
        $key_val = $request->key;

        $type = CarType::where('details_id', $request->id)->first();
        $model_id = $type ? $type->model_id : '';
        //
        $detail = CarDetail::where(['id' => $request->id])->first();

        $model = CarModel::where(['brand_id' => $detail ? $detail->brand_id : 0])->first();
        $brand = Brand::where('id', $detail ? $detail->brand_id : 0)->first();
        $types = CarType::where(['details_id' => $request->id])->get();
        if (count($types) > 0) {
            return view('frontend.ajax.panic.get_car_types', compact('count_value', 'key_val', 'category', 'types', 'model_id', 'model', 'brand', 'detail', 'itype'));
        } else {
            return 'empty';
        }
    }

    public function searchingBrands(Request $request)
    {
        $category = 0;
        $key_val = 0;
        $value = $request->value;
        $name = $request->name;
        $brands = Brand::where('name', 'LIKE', '%' . $value . '%')->get();
        $models = CarModel::where('name', 'LIKE', '%' . $value . '%')->get();
        $details = CarDetail::where('name', 'LIKE', '%' . $value . '%')->get();
        $types = CarType::where('name', 'LIKE', '%' . $value . '%')->get();
        $brands = $brands->merge($models)->merge($details)->merge($types);
        if (count($brands) > 0) {
            return view('frontend.searching.searching', compact('key_val', 'category', 'brands'));
        } else {
            return 'empty';
        }
    }

    public function searchingBrandProducts($id, $category, $chk)
    {

        $cat = Category::where('name', $category)->first();
        if ($chk == 1) {
            $prods = Product::whereJsonContains('brand_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 2) {
            $prods = Product::whereJsonContains('model_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 3) {
            $prods = Product::whereJsonContains('details_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 4) {
            $prods = Product::whereJsonContains('type_id', $id)->where('category_id', $cat->id)
                ->get();
        }

        $cat_name = $category;
        Session::put('cat_type', $category);
        //        $prods = Product::where('category_id', $cat->id)->where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->get();
        return view('frontend.searching.search_res', compact('prods', 'cat_name'));
    }

    public function searchingBrandProductsResult($id, $category, $chk, $brand_id, $model_id, $details_id)
    {
        $cat = Category::where('name', $category)->first();
        if ($chk == 1) {
            $prods = Product::whereJsonContains('brand_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 2) {
            $prods = Product::whereJsonContains('model_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 3) {
            $prods = Product::whereJsonContains('details_id', $id)->where('category_id', $cat->id)
                ->get();
        } elseif ($chk == 4) {
            $prods = Product::whereJsonContains('type_id', $id)->where('category_id', $cat->id)
                ->get();
        }
        $brand = Brand::where('id', $brand_id)->first();
        $model = CarModel::where('id', $model_id)->first();
        $detail = CarDetail::where('id', $details_id)->first();
        $type = CarType::where('id', $id)->first();
        $cat_name = $category;
        Session::put('cat_type', $category);
        //        $prods = Product::where('category_id', $cat->id)->where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->get();
        return view('frontend.searching.search_res', compact('prods', 'brand', 'model', 'detail', 'type', 'cat_name'));
    }
    public function searchingBrandPackages(Request $request, $id, $category)
    {
        Session::put('cat_type', $category);
        $cat = Category::where('name', $category)->first();
        $mpackages = Package::where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->get();
        $packages = Package::where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->get();

        if ($request->package_id == 'All') {
            $packages = Package::where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->get();
        } elseif ($request->has('package_id') && $request->package_id != null) {
            $packages = Package::where(['brand_id' => $id])->orWhere(['model_id' => $id])->orWhere(['details_id' => $id])->orWhere(['type_id' => $id])->orderBy('id', 'ASC')->where('id', $request->package_id)->get();
        }
        return view('frontend.services.packages.index', compact('mpackages', 'packages'));
    }
    public function countChildes(Request $request)
    {
        $cat = Brand::where('name', $request->name)->first();
        if ($cat) {
            $category = Brand::first();
            return view('frontend.searching.count_b', compact('category'));
        }
    }

    //    new

    public function package_details(Request $request, $id)
    {
        $lang   = $request->lang;
        $package = Package::where('id', $id)->first();
        //        $package  = Package::findOrFail($id);
        $aproducts = [];
        $ppr = PackageProduct::where('package_id', $id)->where('type', 'Recommended')->first();
        $ppa = PackageProduct::where('package_id', $id)->where('type', 'Addon')->first();
        $var = $package->products;
        $array = json_decode($var, TRUE);
        $rproducts = json_decode($ppr->products, TRUE);
        if ($ppa) {
            $aproducts = json_decode($ppa->products, TRUE);
        }
        return view('frontend.services.packages.details', compact('package', 'array', 'lang', 'rproducts', 'aproducts'));
    }

    public function back_brands()
    {
        $brands = Brand::get();
        return view('frontend.back.brands', compact('brands'));
    }

    public function panic()
    {
        $brands = Brand::get();
        return view('frontend.panic', compact('brands'));
    }

    public function editCarModelList()
    {
        return view('frontend.searching.edit_car_model_list');
    }

    public function searchResultFun(Request $request)
    {
        if (Auth::user()) {
            $cat = Category::where('name', $request->category_id)->first();
            $prods = Product::where('category_id', $cat->id)->orderBy('name')
                ->get();
            $b_id = $request->b_id;
            if ($b_id) {
                $prods = Product::whereJsonContains('brand_id', $b_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            $m_r_id = $request->m_id;
            if ($m_r_id) {
                $prods = Product::whereJsonContains('model_id', $m_r_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            $cd_id = $request->cd_id;
            if ($cd_id) {
                $prods = Product::whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            $y_id = $request->y_id;
            if ($y_id) {
                $prods = Product::whereJsonContains('year_id', $y_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            $ct_id = $request->ct_id;
            if ($ct_id) {
                $prods = Product::whereJsonContains('year_id', $ct_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            ///multiple brands

            if ($b_id && $m_r_id) {
                $prods = Product::whereJsonContains('brand_id', $b_id)->whereJsonContains('model_id', $m_r_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            if ($b_id && $m_r_id && $cd_id) {
                $prods = Product::whereJsonContains('brand_id', $b_id)->whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            if ($b_id && $m_r_id && $cd_id && $y_id) {
                $prods = Product::whereJsonContains('brand_id', $b_id)->whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->get();
            }
            if ($b_id && $m_r_id && $cd_id && $y_id && $ct_id) {
                $prods = Product::whereJsonContains('brand_id', $b_id)->whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->whereJsonContains('type_id', $ct_id)->get();
            }
            ///multiple models
            if ($m_r_id && $cd_id) {
                $prods = Product::whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            if ($m_r_id && $cd_id && $y_id) {
                $prods = Product::whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->get();
            }
            if ($m_r_id && $cd_id && $y_id && $ct_id) {
                $prods = Product::whereJsonContains('model_id', $m_r_id)->whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->whereJsonContains('type_id', $ct_id)->get();
            }
            ///multiple details
            if ($cd_id && $y_id) {
                $prods = Product::whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->get();
            }
            if ($cd_id && $y_id && $ct_id) {
                $prods = Product::whereJsonContains('details_id', $cd_id)->where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->whereJsonContains('type_id', $ct_id)->get();
            }
            ///multiple years

            if ($y_id && $ct_id) {
                $prods = Product::where('category_id', $cat->id)->orderBy('name')
                    ->whereJsonContains('year_id', $y_id)->whereJsonContains('type_id', $ct_id)->get();
            }



            if ($request->r_brand_id) {
                $brand_id = $request->r_brand_id;
                $model_id = $request->r_model_id;
                $details_id = $request->r_details_id;
                $year_id = $request->r_year_id;
                $type_id = $request->r_type_id;
            } else {
                $brand_id = $request->brand_id ? $request->brand_id : $request->user_brand_id;
                $model_id = $request->model_id ? $request->model_id : $request->user_model_id;
                $details_id = $request->details_id ? $request->details_id : $request->user_details_id;
                $year_id = $request->year_id ? $request->year_id : $request->user_year_id;
                $type_id = $request->type_id ? $request->type_id : $request->user_type_id;
            }
            if ($type_id) {
                $prods = Product::whereJsonContains('type_id', $type_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            } elseif ($year_id) {
                $prods = Product::whereJsonContains('year_id', $year_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            } elseif ($details_id) {
                $prods = Product::whereJsonContains('details_id', $details_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            } elseif ($model_id) {
                $prods = Product::whereJsonContains('model_id', $model_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            } elseif ($brand_id) {
                $prods = Product::whereJsonContains('brand_id', $brand_id)->where('category_id', $cat->id)->orderBy('name')
                    ->get();
            }
            $brand = Brand::where('id', $brand_id)->first();
            $model = CarModel::where('id', $model_id)->first();
            $detail = CarDetail::where('id', $details_id)->first();
            $type = CarType::where('id', $type_id)->first();
            $cat_name =  $request->category_id;
            Session::put('cat_type', $request->category_id);
            Session::put('category_id', $cat->id);



            Session::put('session_brand_id', $request->brand_id);
            Session::put('session_model_id', $request->model_id);
            Session::put('session_details_id', $request->details_id);
            Session::put('session_year_id', $request->year_id);
            Session::put('session_type_id', $request->type_id);




            if ($cat->name == 'Services') {
                if ($model_id) {
                    Session::put('session_model_id', $model_id);
                } else {
                    Session::put('session_model_id', '');
                }



                if ($brand_id && $model_id && $details_id && $year_id && $type_id) {
                    $mpackages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('type_id', $type_id)->whereJsonContains('year_id', $year_id)->orderBy('id', 'ASC')->get();
                    $packages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('type_id', $type_id)->whereJsonContains('year_id', $year_id)->orderBy('id', 'ASC')->get();

                    if ($request->package_id == 'All') {
                        $packages = Package::orderBy('id', 'ASC')->get();
                    } elseif ($request->has('package_id') && $request->package_id != null) {
                        $pack = Package::where('id', $request->package_id)->first();
                        $packages = Package::where('mileage', $pack->mileage)->whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('type_id', $type_id)->whereJsonContains('year_id', $year_id)->orderBy('id', 'ASC')->get();
                    }
                } elseif ($brand_id && $model_id && $details_id && $year_id) {
                    $mpackages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('year_id', $year_id)->orderBy('id', 'ASC')->get();
                    $packages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('year_id', $year_id)->orderBy('id', 'ASC')->get();

                    if ($request->package_id == 'All') {
                        $packages = Package::orderBy('id', 'ASC')->get();
                    } elseif ($request->has('package_id') && $request->package_id != null) {
                        $pack = Package::where('id', $request->package_id)->first();
                        $packages = Package::where('mileage', $pack->mileage)->whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->whereJsonContains('type_id', $type_id)->get();
                    }
                } elseif ($brand_id && $model_id && $details_id) {
                    $mpackages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->orderBy('id', 'ASC')->get();
                    $packages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->orderBy('id', 'ASC')->get();

                    if ($request->package_id == 'All') {
                        $packages = Package::orderBy('id', 'ASC')->get();
                    } elseif ($request->has('package_id') && $request->package_id != null) {
                        $pack = Package::where('id', $request->package_id)->first();
                        $packages = Package::where('mileage', $pack->mileage)->whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->whereJsonContains('details_id', $details_id)->get();
                    }
                } elseif ($brand_id && $model_id) {
                    $mpackages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->orderBy('id', 'ASC')->get();
                    $packages = Package::whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->orderBy('id', 'ASC')->get();

                    if ($request->package_id == 'All') {
                        $packages = Package::orderBy('id', 'ASC')->get();
                    } elseif ($request->has('package_id') && $request->package_id != null) {
                        $pack = Package::where('id', $request->package_id)->first();
                        $packages = Package::where('mileage', $pack->mileage)->whereJsonContains('brand_id', $brand_id)->whereJsonContains('model_id', $model_id)->get();
                    }
                } elseif ($brand_id) {

                    $mpackages = Package::whereJsonContains('brand_id', $brand_id)->orderBy('id', 'ASC')->get();
                    $packages = Package::whereJsonContains('brand_id', $brand_id)->orderBy('id', 'ASC')->get();

                    if ($request->package_id == 'All') {
                        $packages = Package::orderBy('id', 'ASC')->get();
                    } elseif ($request->has('package_id') && $request->package_id != null) {
                        $pack = Package::where('id', $request->package_id)->first();
                        $packages = Package::where('mileage', $pack->mileage)->whereJsonContains('brand_id', $brand_id)->get();
                    }
                }


                if (Auth::user()) {

                    return view('frontend.services.packages.index', compact('mpackages', 'packages', 'cat_name'));
                } else {
                    return redirect('users/login');
                }
            } else {
                if (Auth::user()) {
                    return view('frontend.searching.result_page', compact('brand_id', 'model_id', 'details_id', 'year_id', 'type_id', 'prods', 'brand', 'model', 'detail', 'type', 'cat_name', 'cat', 'm_r_id', 'cd_id', 'b_id', 'y_id', 'ct_id'));
                } else {
                    return redirect('users/login');
                }
            }
        } else {

            Session::put('category_id', $request->category_id);
            Session::put('session_brand_id', $request->brand_id);
            Session::put('session_model_id', $request->model_id);
            Session::put('session_details_id', $request->details_id);
            Session::put('session_year_id', $request->year_id);
            Session::put('session_type_id', $request->type_id);


            return redirect('users/login');
        }
    }

    public function package_remind($id, $user_id)
    {
        $package = Package::where('id', $id)->first();
        return view('frontend.services.packages.remind_package', compact('package'));
    }
    public function package_remind_weekly($id, $user_id)
    {
        $package = Package::where('id', $id)->first();
        return view('frontend.services.packages.remind_package', compact('package'));
    }
    public function about_us()
    {
        return view('frontend.about_us');
    }
}
