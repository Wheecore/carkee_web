<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Battery;
use App\Models\Brand;
use App\Models\FeaturedCategory;
use App\Models\Package;
use App\Models\PackageProduct;
use App\Models\Product;
use App\Models\SizeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductV2Controller extends Controller
{
	public function add_tyre_battery()
	{
		$data['brands'] = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
		$data['feature_categories'] = FeaturedCategory::select('id', 'name')->get();
		$data['size_categories'] = SizeCategory::select('id', 'name')->get();
		$data['subcategories'] = DB::table('service_categories')->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')->select('sct.service_category_id as id', 'sct.name')->where('service_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();
		return view('backend.product.products.add-tyre-battery', $data);
	}

	public function get_all_tyres(Request $request)
	{
		$products = DB::table('products')
			->select('id', 'name', 'brand_id', 'model_id', 'year_id', 'variant_id')
			->when(request('sub_category_id'), function ($q) {
				return $q->where('featured_cat_id', request('sub_category_id'));
			})
			->when(request('sub_child_category_id'), function ($q) {
				return $q->where('featured_sub_cat_id', request('sub_child_category_id'));
			})
			->when(request('size_cat_id'), function ($q) {
				return $q->where('size_category_id', request('size_cat_id'));
			})
			->when(request('sub_cat_id'), function ($q) {
				return $q->where('size_sub_category_id', request('sub_cat_id'));
			})
			->when(request('child_cat_id'), function ($q) {
				return $q->where('size_child_category_id', request('child_cat_id'));
			})
			->where('category_id', 1)
			->get()
			->toArray();
		$html = '';
		$unchecked_html = '';
		foreach ($products as $product) {
			$checked = $this->check_is_checked($request, $product);
			if ($checked) {
				$html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-tyre" name="tyres_' . $product->id . '" value="' . $product->id . '" ' . $checked . '><span class="aiz-square-check"></span></label></div></td><td>' . $product->name . '</td></tr>';
			} else {
				$unchecked_html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-tyre" name="tyres_' . $product->id . '" value="' . $product->id . '"><span class="aiz-square-check"></span></label></div></td><td>' . $product->name . '</td></tr>';
			}
		}
		$unchecked_html .= '<tr class="notfound" style="display: none;"><td colspan="2">No record found</td></tr>';
		$html .= $unchecked_html;
		return $html;
	}

	public function get_all_batteries(Request $request)
	{
		$batteries = DB::table('batteries')
			->select('id', 'name', 'model', 'car_brand_id as brand_id', 'car_model_id as model_id', 'car_year_id as year_id', 'car_variant_id as variant_id')
			->when(request('sub_category_id'), function ($q) {
				return $q->where('sub_category_id', request('sub_category_id'));
			})
			->when(request('sub_child_category_id'), function ($q) {
				return $q->where('sub_child_category_id', request('sub_child_category_id'));
			})
			->where('service_type', 'N')
			->get()
			->toArray();
		$html = '';
		$unchecked_html = '';
		foreach ($batteries as $battery) {
			$checked = $this->check_is_checked($request, $battery);
			if ($checked) {
				$html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-battery" name="batteries_' . $battery->id . '" value="' . $battery->id . '" ' . $checked . '><span class="aiz-square-check"></span></label></div></td><td>' . $battery->name . '</td><td>' . $battery->model . '</td></tr>';
			} else {
				$unchecked_html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-battery" name="batteries_' . $battery->id . '" value="' . $battery->id . '"><span class="aiz-square-check"></span></label></div></td><td>' . $battery->name . '</td><td>' . $battery->model . '</td></tr>';
			}
		}
		$unchecked_html .= '<tr class="notfound" style="display: none;"><td colspan="2">No record found</td></tr>';
		$html .= $unchecked_html;
		return $html;
	}

	public function add_tyre_battery_store(Request $request)
	{
		$request_brand_id = $request->brand_id;
		$request_model_id = $request->model_id;
		$request_year_id = $request->year_id;
		$request_variant_id = $request->variant_id;

		$request->session()->put('request_brand_id', $request_brand_id);
		$request->session()->put('request_model_id', $request_model_id);
		$request->session()->put('request_year_id', $request_year_id);
		$request->session()->put('request_variant_id', $request_variant_id);

		if ($request_brand_id || $request_model_id || $request_year_id || $request_variant_id) {
			// tyres
			$added_tyres = explode(',', $request->added_tyres);
			$products = Product::select('id', 'brand_id', 'model_id', 'year_id', 'variant_id')
				->when(request('featured_cat_id'), function ($q) {
					return $q->where('featured_cat_id', request('featured_cat_id'));
				})
				->when(request('featured_sub_cat_id'), function ($q) {
					return $q->where('featured_sub_cat_id', request('featured_sub_cat_id'));
				})
				->when(request('size_cat_id'), function ($q) {
					return $q->where('size_category_id', request('size_cat_id'));
				})
				->when(request('sub_cat_id'), function ($q) {
					return $q->where('size_sub_category_id', request('sub_cat_id'));
				})
				->when(request('child_cat_id'), function ($q) {
					return $q->where('size_child_category_id', request('child_cat_id'));
				})
				->where('category_id', 1)
				->get();

			foreach ($products as $product) {
				if ($request->input('tyres_' . $product->id) || in_array($product->id, $added_tyres)) {
					$brand_id = (array) (json_decode($product->brand_id) ?? []);
					$model_id = (array) (json_decode($product->model_id) ?? []);
					$year_id = (array) (json_decode($product->year_id) ?? []);
					$variant_id = (array) (json_decode($product->variant_id) ?? []);
					if ($request->input('tyres_' . $product->id)) {
						if ($request->brand_id) {
							$brand_id[] = $request_brand_id;
							$brand_id = array_unique($brand_id);
						}
						if ($request->model_id) {
							$model_id[] = $request_model_id;
							$model_id = array_unique($model_id);
						}
						if ($request->year_id) {
							$year_id[] = $request_year_id;
							$year_id = array_unique($year_id);
						}
						if ($request->variant_id) {
							$variant_id[] = $request_variant_id;
							$variant_id = array_unique($variant_id);
						}
					} elseif (in_array($product->id, $added_tyres)) {
						if ($request->brand_id) {
							if (($key = array_search($request_brand_id, $brand_id)) !== false) {
								unset($brand_id[$key]);
							}
						}
						if ($request->model_id) {
							if (($key = array_search($request_model_id, $model_id)) !== false) {
								unset($model_id[$key]);
							}
						}
						if ($request->year_id) {
							if (($key = array_search($request_year_id, $year_id)) !== false) {
								unset($year_id[$key]);
							}
						}
						if ($request->variant_id) {
							if (($key = array_search($request_variant_id, $variant_id)) !== false) {
								unset($variant_id[$key]);
							}
						}
					}
					$product->brand_id = json_encode($brand_id);
					$product->model_id = json_encode($model_id);
					$product->year_id = json_encode($year_id);
					$product->variant_id = json_encode($variant_id);
					$product->save();
				}
			}

			// batteries
			$added_batteries = explode(',', $request->added_batteries);
			$products = Battery::select('id', 'car_brand_id', 'car_model_id', 'car_year_id', 'car_variant_id')
				->when(request('battery_sub_category_id'), function ($q) {
					return $q->where('sub_category_id', request('battery_sub_category_id'));
				})
				->when(request('battery_sub_child_category_id'), function ($q) {
					return $q->where('sub_child_category_id', request('battery_sub_child_category_id'));
				})
				->get();

			foreach ($products as $product) {
				if ($request->input('batteries_' . $product->id) || in_array($product->id, $added_batteries)) {
					$brand_id = (array) (json_decode($product->car_brand_id) ?? []);
					$model_id = (array) (json_decode($product->car_model_id) ?? []);
					$year_id = (array) (json_decode($product->car_year_id) ?? []);
					$variant_id = (array) (json_decode($product->car_variant_id) ?? []);
					if ($request->input('batteries_' . $product->id)) {
						$brand_id = (array) (json_decode($product->car_brand_id) ?? []);
						if ($request->brand_id) {
							$brand_id[] = $request_brand_id;
							$brand_id = array_unique($brand_id);
						}
						$model_id = (array) (json_decode($product->car_model_id) ?? []);
						if ($request->model_id) {
							$model_id[] = $request_model_id;
							$model_id = array_unique($model_id);
						}
						$year_id = (array) (json_decode($product->car_year_id) ?? []);
						if ($request->year_id) {
							$year_id[] = $request_year_id;
							$year_id = array_unique($year_id);
						}
						$variant_id = (array) (json_decode($product->car_variant_id) ?? []);
						if ($request->variant_id) {
							$variant_id[] = $request_variant_id;
							$variant_id = array_unique($variant_id);
						}
					} elseif (in_array($product->id, $added_batteries)) {
						$brand_id = (array) (json_decode($product->car_brand_id) ?? []);
						if ($request->brand_id) {
							if (($key = array_search($request_brand_id, $brand_id)) !== false) {
								unset($brand_id[$key]);
							}
						}
						$model_id = (array) (json_decode($product->car_model_id) ?? []);
						if ($request->model_id) {
							if (($key = array_search($request_model_id, $model_id)) !== false) {
								unset($model_id[$key]);
							}
						}
						$year_id = (array) (json_decode($product->car_year_id) ?? []);
						if ($request->year_id) {
							if (($key = array_search($request_year_id, $year_id)) !== false) {
								unset($year_id[$key]);
							}
						}
						$variant_id = (array) (json_decode($product->car_variant_id) ?? []);
						if ($request->variant_id) {
							if (($key = array_search($request_variant_id, $variant_id)) !== false) {
								unset($variant_id[$key]);
							}
						}
					}
					$product->car_brand_id = json_encode($brand_id);
					$product->car_model_id = json_encode($model_id);
					$product->car_year_id = json_encode($year_id);
					$product->car_variant_id = json_encode($variant_id);
					$product->save();
				}
			}
		}

		flash(translate('Product has been inserted successfully'))->success();
		return back();
	}

	public function add_parts_carwash_store(Request $request)
	{
		$request_brand_id = $request->brand_id;
		$request_model_id = $request->model_id;
		$request_year_id = $request->year_id;
		$request_variant_id = $request->variant_id;

		$request->session()->put('request_brand_id', $request_brand_id);
		$request->session()->put('request_model_id', $request_model_id);
		$request->session()->put('request_year_id', $request_year_id);
		$request->session()->put('request_variant_id', $request_variant_id);

		if ($request_brand_id || $request_model_id || $request_year_id || $request_variant_id) {
			// parts
			$added_parts = explode(',', $request->added_parts);
			$products = Product::select('products.id as id', 'products.name as name', 'brand_id', 'model_id', 'year_id', 'variant_id')
				->join('categories', 'products.category_id', '=', 'categories.id')
				->when(request('featured_cat_id'), function ($q) {
					return $q->where('featured_cat_id', request('parts_feature_categories'));
				})
				->when(request('featured_sub_cat_id'), function ($q) {
					return $q->where('featured_sub_cat_id', request('parts_featured_sub_cat_id'));
				})
				->when(request('size_cat_id'), function ($q) {
					return $q->where('size_category_id', request('size_cat_id'));
				})
				->when(request('sub_cat_id'), function ($q) {
					return $q->where('size_sub_category_id', request('sub_cat_id'));
				})
				->when(request('child_cat_id'), function ($q) {
					return $q->where('size_child_category_id', request('child_cat_id'));
				})
				// ->where('category_id', 1)
				->where('categories.name', "Parts")
				->get();

			foreach ($products as $product) {
				if ($request->input('parts_' . $product->id) || in_array($product->id, $added_parts)) {
					$brand_id = (array) (json_decode($product->brand_id) ?? []);
					$model_id = (array) (json_decode($product->model_id) ?? []);
					$year_id = (array) (json_decode($product->year_id) ?? []);
					$variant_id = (array) (json_decode($product->variant_id) ?? []);
					if ($request->input('parts_' . $product->id)) {
						if ($request->brand_id) {
							$brand_id[] = $request_brand_id;
							$brand_id = array_unique($brand_id);
						}
						if ($request->model_id) {
							$model_id[] = $request_model_id;
							$model_id = array_unique($model_id);
						}
						if ($request->year_id) {
							$year_id[] = $request_year_id;
							$year_id = array_unique($year_id);
						}
						if ($request->variant_id) {
							$variant_id[] = $request_variant_id;
							$variant_id = array_unique($variant_id);
						}
					} elseif (in_array($product->id, $added_parts)) {
						if ($request->brand_id) {
							if (($key = array_search($request_brand_id, $brand_id)) !== false) {
								unset($brand_id[$key]);
							}
						}
						if ($request->model_id) {
							if (($key = array_search($request_model_id, $model_id)) !== false) {
								unset($model_id[$key]);
							}
						}
						if ($request->year_id) {
							if (($key = array_search($request_year_id, $year_id)) !== false) {
								unset($year_id[$key]);
							}
						}
						if ($request->variant_id) {
							if (($key = array_search($request_variant_id, $variant_id)) !== false) {
								unset($variant_id[$key]);
							}
						}
					}
					$product->brand_id = json_encode($brand_id);
					$product->model_id = json_encode($model_id);
					$product->year_id = json_encode($year_id);
					$product->variant_id = json_encode($variant_id);
					$product->save();
				}
			}

			// carwash
			$added_carwash = explode(',', $request->added_carwash);
			$products = Product::select('products.id as id', 'products.name as name', 'products.brand_id as brand_id', 'model_id', 'year_id', 'variant_id')
				->join('categories', 'products.category_id', '=', 'categories.id')
				->when(request('carwash_sub_category_id'), function ($q) {
					return $q->where('sub_category_id', request('carwash_sub_category_id'));
				})
				->when(request('carwash_sub_child_category_id'), function ($q) {
					return $q->where('sub_child_category_id', request('carwash_sub_child_category_id'));
				})
				->where('categories.name', "Car Wash")
				->get();

			foreach ($products as $product) {
				if ($request->input('carwash_' . $product->id) || in_array($product->id, $added_carwash)) {
					$brand_id = (array) (json_decode($product->brand_id) ?? []);
					$model_id = (array) (json_decode($product->model_id) ?? []);
					$year_id = (array) (json_decode($product->year_id) ?? []);
					$variant_id = (array) (json_decode($product->variant_id) ?? []);
					if ($request->input('carwash_' . $product->id)) {
						$brand_id = (array) (json_decode($product->brand_id) ?? []);
						if ($request->brand_id) {
							$brand_id[] = $request_brand_id;
							$brand_id = array_unique($brand_id);
						}
						$model_id = (array) (json_decode($product->model_id) ?? []);
						if ($request->model_id) {
							$model_id[] = $request_model_id;
							$model_id = array_unique($model_id);
						}
						$year_id = (array) (json_decode($product->year_id) ?? []);
						if ($request->year_id) {
							$year_id[] = $request_year_id;
							$year_id = array_unique($year_id);
						}
						$variant_id = (array) (json_decode($product->variant_id) ?? []);
						if ($request->variant_id) {
							$variant_id[] = $request_variant_id;
							$variant_id = array_unique($variant_id);
						}
					} elseif (in_array($product->id, $added_carwash)) {
						$brand_id = (array) (json_decode($product->brand_id) ?? []);
						if ($request->brand_id) {
							if (($key = array_search($request_brand_id, $brand_id)) !== false) {
								unset($brand_id[$key]);
							}
						}
						$model_id = (array) (json_decode($product->model_id) ?? []);
						if ($request->model_id) {
							if (($key = array_search($request_model_id, $model_id)) !== false) {
								unset($model_id[$key]);
							}
						}
						$year_id = (array) (json_decode($product->year_id) ?? []);
						if ($request->year_id) {
							if (($key = array_search($request_year_id, $year_id)) !== false) {
								unset($year_id[$key]);
							}
						}
						$variant_id = (array) (json_decode($product->variant_id) ?? []);
						if ($request->variant_id) {
							if (($key = array_search($request_variant_id, $variant_id)) !== false) {
								unset($variant_id[$key]);
							}
						}
					}
					$product->brand_id = json_encode($brand_id);
					$product->model_id = json_encode($model_id);
					$product->year_id = json_encode($year_id);
					$product->variant_id = json_encode($variant_id);
					$product->save();
				}
			}
		}

		flash(translate('Product has been inserted successfully'))->success();
		return back();

	}

	public function add_services()
	{
		$data['brands'] = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
		$data['subcategories'] = DB::table('service_categories')
			->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')
			->select('sct.service_category_id as id', 'sct.name')
			->where('service_categories.parent_id', null)
			->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))
			->get()
			->toArray();

		return view('backend.product.products.add-services', $data);
	}

	public function get_all_mileages(Request $request)
	{
		$package = DB::table('packages')
			->when(request('brand_id'), function ($q) {
				return $q->where('brand_id', request('brand_id'));
			})
			->when(request('model_id'), function ($q) {
				return $q->where('model_id', request('model_id'));
			})
			->when(request('year_id'), function ($q) {
				return $q->where('year_id', request('year_id'));
			})
			->when(request('variant_id'), function ($q) {
				return $q->where('variant_id', request('variant_id'));
			})
			->select('mileages')
			->first();

		return json_encode(['mileage' => ($package ? json_decode($package->mileages) : [])]);
	}

	public function get_all_services(Request $request)
	{
		$products = DB::table('products')
			->select('id', 'name', 'brand_id', 'model_id', 'year_id', 'variant_id', 'min_qty')
			->when(request('sub_category_id'), function ($q) {
				return $q->where('sub_category_id', request('sub_category_id'));
			})
			->when(request('sub_child_category_id'), function ($q) {
				return $q->where('sub_child_category_id', request('sub_child_category_id'));
			})
			->where('category_id', 4)
			->get()
			->toArray();

		$service_category = DB::table('service_category_translations')
			->where('service_category_id', request('sub_category_id'))
			->where('lang', 'en')
			->select('name')
			->first();

		$html = '';
		$unchecked_html = '';

		// package products
		$package = DB::table('packages')
			->when(request('brand_id'), function ($q) {
				return $q->where('brand_id', request('brand_id'));
			})
			->when(request('model_id'), function ($q) {
				return $q->where('model_id', request('model_id'));
			})
			->when(request('year_id'), function ($q) {
				return $q->where('year_id', request('year_id'));
			})
			->when(request('variant_id'), function ($q) {
				return $q->where('variant_id', request('variant_id'));
			})
			->select('id')
			->first();

		$products_with_data = [];
		if ($package) {
			$package_products = DB::table('package_products')->select('product_id', 'package_type', 'mileage', 'qty')->where('package_id', $package->id)->where('type', substr($request->group_type, 0, 1))->get()->toArray();
			foreach ($package_products as $pp) {
				$products_with_data[$pp->product_id]['package_type'] = $pp->package_type;
				$products_with_data[$pp->product_id]['mileage'] = $pp->mileage;
				$products_with_data[$pp->product_id]['qty'] = $pp->qty;
			}
		}
		$engine_oil_check = ($service_category && $service_category->name == 'Engine Oil') ? true : false;
		foreach ($products as $product) {
			$input = '';
			if ($engine_oil_check) {
				$t = (isset($products_with_data[$product->id]['package_type']) ? $products_with_data[$product->id]['package_type'] : '');
				$ts = $t == 'semi' ? 'selected' : '';
				$tf = $t == 'fully' ? 'selected' : '';
				$tm = $t == 'mineral' ? 'selected' : '';
				$input = '<td><select class="form-control" name="package_type_' . $product->id . '"><option value="">--' . translate('Select') . '--</option><option value="semi" ' . $ts . '>' . translate('Semi') . '</option><option value="fully" ' . $tf . '>' . translate('Fully') . '</option><option value="mineral" ' . $tm . '> ' . translate('Mineral') . '</option></select></td>';
			} else {
				$m = (isset($products_with_data[$product->id]['mileage']) ? $products_with_data[$product->id]['mileage'] : 0);
				$input = '<td><input type="number" value="' . $m . '" class="form-control" name="mileage_' . $product->id . '"></td>';
			}
			if (isset($products_with_data[$product->id])) {
				$qty = (isset($products_with_data[$product->id]['qty']) ? $products_with_data[$product->id]['qty'] : 1);
				$html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-tyre" name="services_' . $product->id . '" value="' . $product->id . '" checked><span class="aiz-square-check"></span></label></div></td><td>' . $product->name . '</td><td><div class="qty-container"><button class="qty-btn-minus" type="button"><i class="las la-minus"></i></button><input type="number" name="qty_' . $product->id . '" value="' . $qty . '" min="' . $product->min_qty . '" max="20" class="input-qty" readonly /><button class="qty-btn-plus" type="button"><i class="las la-plus"></i></button></div></td>' . $input . '</tr>';
			} else {
				$unchecked_html .= '<tr><td><div class="form-group d-inline-block"><label class="aiz-checkbox"><input type="checkbox" class="check-tyre" name="services_' . $product->id . '" value="' . $product->id . '"><span class="aiz-square-check"></span></label></div></td><td>' . $product->name . '</td><td><div class="qty-container"><button class="qty-btn-minus" type="button"><i class="las la-minus"></i></button><input type="number" name="qty_' . $product->id . '" value="1" min="' . $product->min_qty . '" max="20" class="input-qty" readonly /><button class="qty-btn-plus" type="button"><i class="las la-plus"></i></button></div></td>' . $input . '</tr>';
			}
		}
		$unchecked_html .= '<tr class="notfound" style="display: none;"><td colspan="2">No record found</td></tr>';
		$html .= $unchecked_html;
		return $html;
	}

	public function add_services_store(Request $request)
	{
		$request_brand_id = $request->brand_id;
		$request_model_id = $request->model_id;
		$request_year_id = $request->year_id;
		$request_variant_id = $request->variant_id;

		$request->session()->put('request_brand_id', $request_brand_id);
		$request->session()->put('request_model_id', $request_model_id);
		$request->session()->put('request_year_id', $request_year_id);
		$request->session()->put('request_variant_id', $request_variant_id);

		// services
		$added_services = explode(',', $request->added_services);
		$services_products = [];
		$products = Product::select('id', 'brand_id', 'model_id', 'year_id', 'variant_id')
			->when(request('sub_category_id'), function ($q) {
				return $q->where('sub_category_id', request('sub_category_id'));
			})->when(request('sub_child_category_id'), function ($q) {
			return $q->where('sub_child_category_id', request('sub_child_category_id'));
		})
			->where('category_id', 4)
			->get();

		foreach ($products as $product) {
			$brand_id = (array) (json_decode($product->brand_id) ?? []);
			$model_id = (array) (json_decode($product->model_id) ?? []);
			$year_id = (array) (json_decode($product->year_id) ?? []);
			$variant_id = (array) (json_decode($product->variant_id) ?? []);
			if ($request->input('services_' . $product->id) || in_array($product->id, $added_services)) {
				if ($request->input('services_' . $product->id)) {
					$services_products[] = $product->id;
					if ($request->brand_id) {
						$brand_id[] = $request_brand_id;
						$brand_id = array_unique($brand_id);
					}
					if ($request->model_id) {
						$model_id[] = $request_model_id;
						$model_id = array_unique($model_id);
					}
					if ($request->year_id) {
						$year_id[] = $request_year_id;
						$year_id = array_unique($year_id);
					}
					if ($request->variant_id) {
						$variant_id[] = $request_variant_id;
						$variant_id = array_unique($variant_id);
					}
				} elseif (in_array($product->id, $added_services)) {
					if ($request->brand_id) {
						if (($key = array_search($request_brand_id, $brand_id)) !== false) {
							unset($brand_id[$key]);
						}
					}
					if ($request->model_id) {
						if (($key = array_search($request_model_id, $model_id)) !== false) {
							unset($model_id[$key]);
						}
					}
					if ($request->year_id) {
						if (($key = array_search($request_year_id, $year_id)) !== false) {
							unset($year_id[$key]);
						}
					}
					if ($request->variant_id) {
						if (($key = array_search($request_variant_id, $variant_id)) !== false) {
							unset($variant_id[$key]);
						}
					}
				}
			}

			$product->brand_id = json_encode($brand_id);
			$product->model_id = json_encode($model_id);
			$product->year_id = json_encode($year_id);
			$product->variant_id = json_encode($variant_id);
			$product->save();
		}

		$package = Package::when(request('brand_id'), function ($q) {
			return $q->where('brand_id', request('brand_id'));
		})
			->when(request('model_id'), function ($q) {
				return $q->where('model_id', request('model_id'));
			})
			->when(request('year_id'), function ($q) {
				return $q->where('year_id', request('year_id'));
			})
			->when(request('variant_id'), function ($q) {
				return $q->where('variant_id', request('variant_id'));
			})
			->first();

		if (!$package) {
			$package = new Package();
		}
		$package->mileages = json_encode($request->mileages);
		$package->brand_id = $request->brand_id;
		$package->model_id = $request->model_id;
		$package->year_id = $request->year_id;
		$package->variant_id = $request->variant_id;
		$package->expiry_month = 6;
		$package->save();

		// package products
		foreach ($services_products as $product_id) {
			$package_product = PackageProduct::where('package_id', $package->id)->where('product_id', $product_id)->where('type', $request->group_type)->first();
			if (!$package_product) {
				$package_product = new PackageProduct();
			}
			$package_product->package_id = $package->id;
			$package_product->product_id = $product_id;
			$package_product->type = $request->group_type;
			$package_product->package_type = $request->input('package_type_' . $product_id);
			$package_product->mileage = $request->input('mileage_' . $product_id);
			$package_product->qty = $request->input('qty_' . $product_id) ?? 0;
			$package_product->save();
		}

		flash(translate('Product has been inserted successfully'))->success();
		return back();
	}

	public function check_is_checked($request, $product)
	{
		$checked = '';
		$s1_flag = false;
		$s2_flag = false;
		$s3_flag = false;
		$s4_flag = false;
		$product_brand_id = (array) (json_decode($product->brand_id) ?? []);
		$product_model_id = (array) (json_decode($product->model_id) ?? []);
		$product_year_id = (array) (json_decode($product->year_id) ?? []);
		$product_variant_id = (array) (json_decode($product->variant_id) ?? []);
		if ($request->brand_id) {
			if (count($product_brand_id)) {
				if (in_array($request->brand_id, $product_brand_id)) {
					$checked = 'checked';
					$s1_flag = true;
				} else {
					$s1_flag = false;
					$checked = '';
				}
			} else {
				$s1_flag = false;
				$checked = '';
			}
		} else {
			$s1_flag = true;
		}

		if ($request->model_id) {
			if (count($product_model_id)) {
				if (in_array($request->model_id, $product_model_id)) {
					$checked = 'checked';
					$s2_flag = true;
				} else {
					$s2_flag = false;
					$checked = '';
				}
			} else {
				$s2_flag = false;
				$checked = '';
			}
		} else {
			$s2_flag = true;
		}

		if ($request->year_id) {
			if (count($product_year_id)) {
				if (in_array($request->year_id, $product_year_id)) {
					$checked = 'checked';
					$s3_flag = true;
				} else {
					$checked = '';
					$s3_flag = false;
				}
			} else {
				$checked = '';
				$s3_flag = false;
			}
		} else {
			$s3_flag = true;
		}

		if ($request->variant_id) {
			if (count($product_variant_id)) {
				if (in_array($request->variant_id, $product_variant_id)) {
					$checked = 'checked';
					$s4_flag = true;
				} else {
					$checked = '';
					$s4_flag = false;
				}
			} else {
				$checked = '';
				$s4_flag = false;
			}
		} else {
			$s4_flag = true;
		}

		if ($checked != 'checked') {
			return '';
		} elseif ($s1_flag && $s2_flag && $s3_flag && $s4_flag) {
			return 'checked';
		} else {
			return '';
		}
	}

	// add parts
	public function add_parts_carwash()
	{
		$data['brands'] = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
		$data['parts_feature_categories'] = FeaturedCategory::select('id', 'name')->where("type", "parts")->get();
		$data['carwash_feature_categories'] = FeaturedCategory::select('id', 'name')->where("type", "car_wash")->get();
		// $data['size_categories'] = SizeCategory::select('id', 'name')->get();
		$data['parts_subcategories'] = DB::table('service_categories')->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')->select('sct.service_category_id as id', 'sct.name')->where('service_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();

		return view('backend.product.products.create-parts', $data);
	}

	// get all parts
	public function get_all_parts(Request $request)
	{
		$products = DB::table('products')
			->select('products.id as id', 'products.name as name', 'brand_id', 'model_id', 'year_id', 'variant_id')
			->when(request('sub_category_id'), function ($q) {
				return $q->where('featured_cat_id', request('sub_category_id'));
			})
			->when(request('sub_child_category_id'), function ($q) {
				return $q->where('featured_sub_cat_id', request('sub_child_category_id'));
			})
			->when(request('size_cat_id'), function ($q) {
				return $q->where('size_category_id', request('size_cat_id'));
			})
			->when(request('sub_cat_id'), function ($q) {
				return $q->where('size_sub_category_id', request('sub_cat_id'));
			})
			->when(request('child_cat_id'), function ($q) {
				return $q->where('size_child_category_id', request('child_cat_id'));
			})
			->join('categories', 'products.category_id', '=', 'categories.id')
			->where('categories.name', request('categories_name'))
			->get()
			->toArray();

		$html = '';
		$unchecked_html = '';
		$name = request("name");

		foreach ($products as $product) {
			$checked = $this->check_is_checked($request, $product);
			if ($checked) {
				// Use double quotes and curly braces for variable interpolation
				$html .= "<tr>
							<td>
								<div class='form-group d-inline-block'>
									<label class='aiz-checkbox'>
										<input type='checkbox' class='check-{$name}' name='{$name}_{$product->id}' value='{$product->id}' {$checked}>
											<span class='aiz-square-check'></span>
										</label>
									</div>
								</td>
							<td>{$product->name}</td>
							</tr>";
			} else {
				$unchecked_html .= "<tr>
										<td>
											<div class='form-group d-inline-block'>
												<label class='aiz-checkbox'>
													<input type='checkbox' class='check-{$name}' name='{$name}_{$product->id}' value='{$product->id}'>
													<span class='aiz-square-check'></span>
												</label>
											</div>
										</td>
										<td>{$product->name}</td>
									</tr>";
			}
		}

		if ($unchecked_html == '') {
			$unchecked_html .= '<tr class="notfound"><td colspan="2">No record found</td></tr>';
		}

		$html .= $unchecked_html;
		return $html;
	}

}
