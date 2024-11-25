<?php

use App\Models\Address;
use App\Models\BusinessSetting;
use App\Models\City;
use App\Models\Currency;
use App\Models\Product;
use App\Models\SubSubCategory;
use App\Models\Translation;
use App\Models\Upload;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

//highlights the selected navigation on admin panel
if (!function_exists('sendSMS')) {
	function sendSMS($to, $from, $text, $template_id)
	{
		return true;
	}
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutesAdmin')) {
	function areActiveRoutesAdmin(array $routes, $output = "mm-active")
	{
		foreach ($routes as $route) {
			if (Route::currentRouteName() == $route) {
				return $output;
			}

		}
	}
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
	function areActiveRoutes(array $routes, $output = "active")
	{
		foreach ($routes as $route) {
			if (Route::currentRouteName() == $route) {
				return $output;
			}

		}
	}
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
	function areActiveRoutesHome(array $routes, $output = "active")
	{
		foreach ($routes as $route) {
			if (Route::currentRouteName() == $route) {
				return $output;
			}

		}
	}
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
	function default_language()
	{
		return env("DEFAULT_LANGUAGE");
	}
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
	function convert_to_usd($amount)
	{
		$business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
		if ($business_settings != null) {
			$currency = Currency::find($business_settings->value);
			return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
		}
	}
}

if (!function_exists('convert_to_kes')) {
	function convert_to_kes($amount)
	{
		$business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
		if ($business_settings != null) {
			$currency = Currency::find($business_settings->value);
			return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
		}
	}
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
	function filter_products($products)
	{
		$verified_sellers = verified_sellers_id();
		if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
			return $products->where('published', 1)->orderBy('created_at', 'desc')->where(function ($p) use ($verified_sellers) {
				$p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
					$q->whereIn('user_id', $verified_sellers);
				});
			});
		} else {
			return $products->where('published', 1)->where('added_by', 'admin')->orderBy('created_at', 'desc');
		}
	}
}

//cache products based on category
if (!function_exists('get_cached_products')) {
	function get_cached_products($category_id = null)
	{
		$products = Product::where('published', 1);
		$verified_sellers = verified_sellers_id();
		if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
			$products = $products->where(function ($p) use ($verified_sellers) {
				$p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
					$q->whereIn('user_id', $verified_sellers);
				});
			});
		} else {
			$products = $products->where('added_by', 'admin');
		}

		if ($category_id != null) {
			return Cache::remember('products-category-' . $category_id, 86400, function () use ($category_id, $products) {
				return $products->where('category_id', $category_id)->latest()->take(12)->get();
			});
		} else {
			return Cache::remember('products', 86400, function () use ($products) {
				return $products->latest()->get();
			});
		}
	}
}

if (!function_exists('verified_sellers_id')) {
	function verified_sellers_id()
	{
		return App\Models\Seller::where('verification_status', 1)->get()->pluck('user_id')->toArray();
	}
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
	function convert_price($price)
	{
		$business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
		if ($business_settings != null) {
			$currency = Currency::find($business_settings->value);
			$price = floatval($price) / floatval($currency->exchange_rate);
		}

		$code = Currency::findOrFail(get_setting('system_default_currency'))->code;
		if (Session::has('currency_code')) {
			$currency = Currency::where('code', Session::get('currency_code', $code))->first();
		} else {
			$currency = Currency::where('code', $code)->first();
		}

		$price = floatval($price) * floatval($currency->exchange_rate);
		return $price;
	}
}

//formats currency
if (!function_exists('format_price')) {
	function format_price($price)
	{
		if (get_setting('decimal_separator') == 1) {
			$fomated_price = number_format($price, get_setting('no_of_decimals'));
		} else {
			$fomated_price = number_format($price, get_setting('no_of_decimals'), ',', ' ');
		}

		if (get_setting('symbol_format') == 1) {
			return currency_symbol() . $fomated_price;
		} else if (get_setting('symbol_format') == 3) {
			return currency_symbol() . ' ' . $fomated_price;
		} else if (get_setting('symbol_format') == 4) {
			return $fomated_price . ' ' . currency_symbol();
		}
		return $fomated_price . currency_symbol();
	}
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
	function single_price($price)
	{
		return format_price(convert_price($price));
	}
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
	function home_price($product)
	{
		$lowest_price = $product->unit_price;
		$highest_price = $product->unit_price;

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$lowest_price += ($lowest_price * $product_tax->tax) / 100;
					$highest_price += ($highest_price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$lowest_price += $product_tax->tax;
					$highest_price += $product_tax->tax;
				}
			}
		}

		$lowest_price = convert_price($lowest_price);
		$highest_price = convert_price($highest_price);

		if ($lowest_price == $highest_price) {
			return format_price($lowest_price);
		} else {
			return format_price($lowest_price) . ' - ' . format_price($highest_price);
		}
	}
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
	function home_discounted_price($product)
	{
		$lowest_price = $product->unit_price;
		$highest_price = $product->unit_price;

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
				$lowest_price -= ($lowest_price * $product->discount) / 100;
				$highest_price -= ($highest_price * $product->discount) / 100;
			} elseif ($product->discount_type == 'amount') {
				$lowest_price -= $product->discount;
				$highest_price -= $product->discount;
			}
		}

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$lowest_price += ($lowest_price * $product_tax->tax) / 100;
					$highest_price += ($highest_price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$lowest_price += $product_tax->tax;
					$highest_price += $product_tax->tax;
				}
			}
		}

		$lowest_price = convert_price($lowest_price);
		$highest_price = convert_price($highest_price);

		if ($lowest_price == $highest_price) {
			return format_price($lowest_price);
		} else {
			return format_price($lowest_price) . ' - ' . format_price($highest_price);
		}
	}
}

//Shows Base Price
if (!function_exists('home_base_price_by_id')) {
	function home_base_price_by_id($id)
	{
		$product = Product::findOrFail($id);
		$price = $product->unit_price;
		$tax = 0;

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}
		$price += $tax;
		return format_price(convert_price($price));
	}
}
if (!function_exists('home_base_price')) {
	function home_base_price($product)
	{
		if ($product->category_id == 1) {
			$price = $product->quantity_1_price;
		} else {
			$price = $product->unit_price;
		}
		$tax = 0;
		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}
		$price += $tax;
		return format_price(convert_price($price));
	}
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price_by_id')) {
	function home_discounted_base_price_by_id($id)
	{
		$product = Product::findOrFail($id);
		$price = $product->unit_price;
		$tax = 0;

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

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}
		$price += $tax;

		return format_price(convert_price($price));
	}
}
//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
	function home_discounted_base_price($product)
	{
		if ($product->category_id == 1) {
			$price = $product->quantity_1_price;
		} else {
			$price = $product->unit_price;
		}
		$tax = 0;
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

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}
		$price += $tax;
		return format_price(convert_price($price));
	}
}

if (!function_exists('currency_symbol')) {
	function currency_symbol()
	{
		$code = Currency::findOrFail(get_setting('system_default_currency'))->code;
		if (Session::has('currency_code')) {
			$currency = Currency::where('code', Session::get('currency_code', $code))->first();
		} else {
			$currency = Currency::where('code', $code)->first();
		}
		return $currency->symbol;
	}
}

if (!function_exists('renderStarRating')) {
	function renderStarRating($rating, $maxRating = 5)
	{
		$fullStar = "<i class = 'las la-star active'></i>";
		$halfStar = "<i class = 'las la-star half'></i>";
		$emptyStar = "<i class = 'las la-star'></i>";
		$rating = $rating <= $maxRating ? $rating : $maxRating;

		$fullStarCount = (int) $rating;
		$halfStarCount = ceil($rating) - $fullStarCount;
		$emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

		$html = str_repeat($fullStar, $fullStarCount);
		$html .= str_repeat($halfStar, $halfStarCount);
		$html .= str_repeat($emptyStar, $emptyStarCount);
		echo $html;
	}
}

//Api
if (!function_exists('homeBasePrice')) {
	function homeBasePrice($product)
	{
		$price = $product->unit_price;
		$tax = 0;
		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}

		$price += $tax;
		//        if ($product->tax_type == 'percent') {
		//            $price += ($price * $product->tax) / 100;
		//        } elseif ($product->tax_type == 'amount') {
		//            $price += $product->tax;
		//        }
		return $price;
	}
}

if (!function_exists('homeDiscountedBasePrice')) {
	function homeDiscountedBasePrice($product, $tyre_product_price = 0)
	{
		if ($product->category_id == 4 || $product->category_id == 5) {
			$price = $product->unit_price;
		} else {
			$price = $tyre_product_price;
		}
		$tax = 0;
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

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$tax += ($price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$tax += $product_tax->tax;
				}
			}
		}
		$price += $tax;
		return $price;
	}
}

if (!function_exists('homePrice')) {
	function homePrice($product)
	{
		$lowest_price = $product->unit_price;
		$highest_price = $product->unit_price;
		$tax = 0;

		//        if ($product->tax_type == 'percent') {
		//            $lowest_price += ($lowest_price*$product->tax)/100;
		//            $highest_price += ($highest_price*$product->tax)/100;
		//        }
		//        elseif ($product->tax_type == 'amount') {
		//            $lowest_price += $product->tax;
		//            $highest_price += $product->tax;
		//        }
		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$lowest_price += ($lowest_price * $product_tax->tax) / 100;
					$highest_price += ($highest_price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$lowest_price += $product_tax->tax;
					$highest_price += $product_tax->tax;
				}
			}
		}

		$lowest_price = convertPrice($lowest_price);
		$highest_price = convertPrice($highest_price);

		return $lowest_price . ' - ' . $highest_price;
	}
}

if (!function_exists('homeDiscountedPrice')) {
	function homeDiscountedPrice($product)
	{
		$lowest_price = $product->unit_price;
		$highest_price = $product->unit_price;

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
				$lowest_price -= ($lowest_price * $product->discount) / 100;
				$highest_price -= ($highest_price * $product->discount) / 100;
			} elseif ($product->discount_type == 'amount') {
				$lowest_price -= $product->discount;
				$highest_price -= $product->discount;
			}
		}

		if ($product->taxes) {
			foreach ($product->taxes as $product_tax) {
				if ($product_tax->tax_type == 'percent') {
					$lowest_price += ($lowest_price * $product_tax->tax) / 100;
					$highest_price += ($highest_price * $product_tax->tax) / 100;
				} elseif ($product_tax->tax_type == 'amount') {
					$lowest_price += $product_tax->tax;
					$highest_price += $product_tax->tax;
				}
			}
		}

		$lowest_price = convertPrice($lowest_price);
		$highest_price = convertPrice($highest_price);

		return $lowest_price . ' - ' . $highest_price;
	}
}

if (!function_exists('brandsOfCategory')) {
	function brandsOfCategory($category_id)
	{
		$brands = [];
		$subCategories = SubCategory::where('category_id', $category_id)->get();
		foreach ($subCategories as $subCategory) {
			$subSubCategories = SubSubCategory::where('sub_category_id', $subCategory->id)->get();
			foreach ($subSubCategories as $subSubCategory) {
				$brand = json_decode($subSubCategory->brands);
				foreach ($brand as $b) {
					if (in_array($b, $brands)) {
						continue;
					}

					array_push($brands, $b);
				}
			}
		}
		return $brands;
	}
}

if (!function_exists('convertPrice')) {
	function convertPrice($price)
	{
		$business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
		if ($business_settings != null) {
			$currency = Currency::find($business_settings->value);
			$price = floatval($price) / floatval($currency->exchange_rate);
		}
		$code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
		if (Session::has('currency_code')) {
			$currency = Currency::where('code', Session::get('currency_code', $code))->first();
		} else {
			$currency = Currency::where('code', $code)->first();
		}
		$price = floatval($price) * floatval($currency->exchange_rate);
		return $price;
	}
}

function get_all_languages()
{
	return Cache::remember('all-languages', 86400, function () {
		return \DB::table('languages')->select('id', 'name', 'code', 'rtl')->get()->toArray();
	});
}

function get_all_categories()
{
	return Cache::remember(('all-categories-' . (\App::getLocale() ?? 'en')), 86400, function () {
		return \DB::table('categories')->join('category_translations', 'category_translations.category_id', '=', 'categories.id')->select('categories.id', 'category_translations.name')->where('category_translations.lang', (\App::getLocale() ?? 'en'))->get()->toArray();
	});
}

function translate($key, $lang = null)
{
	if ($lang == null) {
		$lang = App::getLocale();
	}

	$translation_def = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'))->where('lang_key', $key)->first();
	if ($translation_def == null) {
		$translation_def = new Translation;
		$translation_def->lang = env('DEFAULT_LANGUAGE', 'en');
		$translation_def->lang_key = $key;
		$translation_def->lang_value = $key;
		$translation_def->save();
	}

	//Check for session lang
	$translation_locale = Translation::where('lang_key', $key)->where('lang', $lang)->first();
	if ($translation_locale != null && $translation_locale->lang_value != null) {
		return $translation_locale->lang_value;
	} elseif ($translation_def->lang_value != null) {
		return $translation_def->lang_value;
	} else {
		return $key;
	}
}

function remove_invalid_charcaters($str)
{
	$str = str_ireplace(array("\\"), '', $str);
	return str_ireplace(array('"'), '\"', $str);
}

function getShippingCost($carts, $index)
{
	$admin_products = array();
	$seller_products = array();
	$calculate_shipping = 0;

	foreach ($carts as $key => $cartItem) {
		$product = \App\Models\Product::find($cartItem['product_id']);
		if ($product->added_by == 'admin') {
			array_push($admin_products, $cartItem['product_id']);
		} else {
			$product_ids = array();
			if (array_key_exists($product->user_id, $seller_products)) {
				$product_ids = $seller_products[$product->user_id];
			}
			array_push($product_ids, $cartItem['product_id']);
			$seller_products[$product->user_id] = $product_ids;
		}
	}

	//Calculate Shipping Cost
	if (get_setting('shipping_type') == 'flat_rate') {
		$calculate_shipping = get_setting('flat_rate_shipping_cost');
	} elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
		if (!empty($admin_products)) {
			$calculate_shipping = get_setting('shipping_cost_admin');
		}
		if (!empty($seller_products)) {
			foreach ($seller_products as $key => $seller_product) {
				$calculate_shipping += \App\Models\Shop::where('user_id', $key)->first()->shipping_cost;
			}
		}
	} elseif (get_setting('shipping_type') == 'area_wise_shipping') {
		$shipping_info = Address::where('id', $carts[0]['address_id'])->first();
		$city = City::where('name', $shipping_info->city)->first();
		if ($city != null) {
			$calculate_shipping = $city->cost;
		}
	}

	$cartItem = $carts[$index];
	$product = \App\Models\Product::find($cartItem['product_id']);

	if (get_setting('shipping_type') == 'flat_rate') {
		return $calculate_shipping / count($carts);
	} elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
		if ($product->added_by == 'admin') {
			return get_setting('shipping_cost_admin') / count($admin_products);
		} else {
			return \App\Models\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
		}
	} elseif (get_setting('shipping_type') == 'area_wise_shipping') {
		if ($product->added_by == 'admin') {
			return $calculate_shipping / count($admin_products);
		} else {
			return $calculate_shipping / count($seller_products[$product->user_id]);
		}
	} else {
		return \App\Models\Product::find($cartItem['product_id'])->shipping_cost;
	}
}

// new version due package added
function get_shipping_cost($carts, $index, $product, $shipping_info)
{
	$admin_products = array();
	$seller_products = array();
	$calculate_shipping = 0;

	foreach ($carts as $key => $cartItem) {
		if ($product->added_by == 'admin') {
			array_push($admin_products, $cartItem['product_id']);
		} else {
			$product_ids = array();
			if (array_key_exists($product->user_id, $seller_products)) {
				$product_ids = $seller_products[$product->user_id];
			}
			array_push($product_ids, $cartItem['product_id']);
			$seller_products[$product->user_id] = $product_ids;
		}
	}

	//Calculate Shipping Cost
	if (get_setting('shipping_type') == 'flat_rate') {
		$calculate_shipping = get_setting('flat_rate_shipping_cost');
	} elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
		if (!empty($admin_products)) {
			$calculate_shipping = get_setting('shipping_cost_admin');
		}
		if (!empty($seller_products)) {
			foreach ($seller_products as $key => $seller_product) {
				$calculate_shipping += \DB::table('shops')->select('shipping_cost')->where('user_id', $key)->first()->shipping_cost;
			}
		}
	} elseif (get_setting('shipping_type') == 'area_wise_shipping') {
		if (isset($shipping_info['city'])) {
			$city = City::where('name', $shipping_info['city'])->first();
			if ($city != null) {
				$calculate_shipping = $city->cost;
			}
		}
	}

	$cartItem = $carts[$index];

	if (get_setting('shipping_type') == 'flat_rate') {
		return $calculate_shipping / count($carts);
	} elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
		if ($product->added_by == 'admin') {
			return get_setting('shipping_cost_admin') / count($admin_products);
		} else {
			return (\DB::table('shops')->select('shipping_cost')->where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]));
		}
	} elseif (get_setting('shipping_type') == 'area_wise_shipping') {
		if ($product->added_by == 'admin') {
			return $calculate_shipping / count($admin_products);
		} else {
			return $calculate_shipping / count($seller_products[$product->user_id]);
		}
	} else {
		return $product->shipping_cost;
	}
}

function timezones()
{
	return Timezones::timezonesToArray();
}

if (!function_exists('app_timezone')) {
	function app_timezone()
	{
		return config('app.timezone');
	}
}

if (!function_exists('api_asset')) {
	function api_asset($id)
	{
		if (($asset = \App\Models\Upload::find($id)) != null) {
			return my_asset($asset->file_name);
		}
		return "";
	}
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
	function uploaded_asset($id)
	{
		if (($asset = \App\Models\Upload::find($id)) != null) {
			return my_asset($asset->file_name);
		}
		return null;
	}
}

if (!function_exists('my_asset')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function my_asset($path, $secure = null)
	{
		if (env('FILESYSTEM_DRIVER') == 's3') {
			return Storage::disk('s3')->url($path);
		} else {
			return app('url')->asset('public/' . $path, $secure);
		}
	}
}

if (!function_exists('static_asset')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function static_asset($path, $secure = null)
	{
		// return app('url')->asset('public/' . $path, $secure);
		// get APP_ENVAPP_ENV
		if (env('APP_ENV') == 'local') {
			return asset($path, $secure);
		} else {
			return app('url')->asset('public/' . $path, $secure);
		}
// return app('url')->asset($path, $secure);

	}
}

if (!function_exists('isHttps')) {
	function isHttps()
	{
		return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
	}
}

if (!function_exists('getBaseURL')) {
	function getBaseURL()
	{
		$root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

		return $root;
	}
}

if (!function_exists('getFileBaseURL')) {
	function getFileBaseURL()
	{
		if (env('FILESYSTEM_DRIVER') == 's3') {
			return env('AWS_URL') . '/';
		} else {
			return getBaseURL() . 'public/';
		}
	}
}

if (!function_exists('isUnique')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function isUnique($email)
	{
		$user = \App\User::where('email', $email)->first();

		if ($user == null) {
			return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
		} else {
			return '0';
		}
	}
}

if (!function_exists('get_setting')) {
	function get_setting($key, $default = null)
	{
		$settings = Cache::remember('business_settings', 86400, function () {
			return BusinessSetting::all();
		});

		$setting = $settings->where('type', $key)->first();
		return $setting == null ? $default : $setting->value;
	}
}

function hex2rgba($color, $opacity = false)
{
	return Colorcodeconverter::convertHexToRgba($color, $opacity);
}

if (!function_exists('isAdmin')) {
	function isAdmin()
	{
		if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
			return true;
		}
		return false;
	}
}

if (!function_exists('isSeller')) {
	function isSeller()
	{
		if (Auth::check() && Auth::user()->user_type == 'seller') {
			return true;
		}
		return false;
	}
}

if (!function_exists('isCustomer')) {
	function isCustomer()
	{
		if (Auth::check() && Auth::user()->user_type == 'customer') {
			return true;
		}
		return false;
	}
}

if (!function_exists('formatBytes')) {
	function formatBytes($bytes, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		// Uncomment one of the following alternatives
		$bytes /= pow(1024, $pow);
		// $bytes /= (1 << (10 * $pow));

		return round($bytes, $precision) . ' ' . $units[$pow];
	}
}

// duplicates m$ excel's ceiling function
if (!function_exists('ceiling')) {
	function ceiling($number, $significance = 1)
	{
		return (is_numeric($number) && is_numeric($significance)) ? (ceil($number / $significance) * $significance) : false;
	}
}

if (!function_exists('get_images')) {
	function get_images($given_ids, $with_trashed = false)
	{
		if (is_array($given_ids)) {
			$ids = $given_ids;
		} else if (is_null($given_ids)) {
			$ids = [];
		} else {
			$ids = explode(",", $given_ids);
		}
		return $with_trashed ? Upload::withTrashed()->whereIn('id', $ids)->get() : Upload::whereIn('id', $ids)->get();
	}
}

//for api
if (!function_exists('get_images_path')) {
	function get_images_path($given_ids, $with_trashed = false)
	{
		$paths = [];
		$images = get_images($given_ids, $with_trashed);
		if (!$images->isEmpty()) {
			foreach ($images as $image) {
				$paths[] = !is_null($image) ? my_asset($image->file_name) : "";
			}
		}

		return $paths;
	}
}

// Firebase notification generator
function send_firebase_notification($array)
{
	$tokens = [];
	$device_token = $array['device_token'];
	foreach ($device_token as $value) {
		$tokens[] = $value->token;
	}
	if (count($tokens)) {
		$postfields = array(
			"registration_ids" => $tokens,
			"priority" => "high",
			"importance" => "max",
			"notification" => array(
				"body" => $array['title'],
				"title" => env('APP_NAME'),
			));
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($postfields),
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . env('FIREBASE_NOTIFICATION_API'),
				'Content-Type: application/json',
			),
		));

		// $response = curl_exec($curl);
		curl_exec($curl);
		curl_close($curl);
		// echo $response;
	}
}

function get_client_ip()
{
	$ipaddress = '';
	if (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if (isset($_SERVER['REMOTE_ADDR'])) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}

function get_local_time()
{
	// $ip = file_get_contents("http://ipecho.net/plain");
	$ip = get_client_ip();
	$url = 'http://ip-api.com/json/' . $ip;
	$timezone = file_get_contents($url);
	$tz = json_decode($timezone, true);
	$tz = isset($tz['timezone']) ? $tz['timezone'] : 'Asia/Kuala_Lumpur';
	return $tz;
}

function convert_datetime_to_local_timezone($datetime, $timezone)
{
	return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->setTimezone($timezone)->format(env('DATE_FORMAT') . ' h:i a');
}

function convert_datetime_to_local_timezone_for_notification($datetime, $timezone)
{
	return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->setTimezone($timezone)->format('d-m-Y H:i:s');
}

function user_timezone($user_id)
{
	return User::where('id', $user_id)->select('timezone')->first()->timezone;
}

function accurate_mileage($mileage)
{
	return ceil($mileage / 5000) * 5000;
}

function car_wash_type($type)
{
	switch ($type) {
		case 'O':
			return translate('One Time');
			break;
		case 'S':
			return translate('Subscription');
			break;
		case 'M':
			return translate('Membership');
			break;
	}
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
	if (($lat1 == $lat2) && ($lon1 == $lon2)) {
		return 0;
	} else {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
}
