<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\CarYear;
use App\Models\Category;
use App\Models\FeaturedCategory;
use App\Models\FeaturedSubCategory;
use App\Models\Deal;
use App\Models\DealProduct;
use App\Models\BrandData;
use App\Models\CarVariant;
use App\Models\Product;
use App\Models\ServiceProductsExport;
use App\Models\TyreProductsExport;
use App\Models\ProductTax;
use App\Models\ProductTranslation;
use App\Models\SizeCategory;
use App\Models\SizeChildCategory;
use App\Models\SizeSubCategory;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function all_products(Request $request)
    {
        $qty_filter = null;
        $category_id = null;
        $tyre_brand_id = null;
        $sort_search = null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('cat_id') && $request->cat_id != null) {
            $products = $products->where('category_id', $request->cat_id);
            $category_id = $request->cat_id;
        }
        if ($request->has('tyre_brand_id') && $request->tyre_brand_id != null) {
            $products = $products->where('category_id', 1)->where('featured_cat_id', $request->tyre_brand_id);
            $tyre_brand_id = $request->tyre_brand_id;
        }
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%')->orWhere('tags', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        if ($request->qty_filter != null) {
            $products = $products->where('low_stock_quantity', '<=', 20);
            $qty_filter = $request->qty_filter;
        }

        $products = $products->paginate(15);

        $categories = Category::whereIn('id', [1, 4, 5])->select('id', 'name')->get();
        $tyre_brands = FeaturedCategory::select('id', 'name')->get();
        $products_without_imgs = DB::table('products')->whereNull('thumbnail_img')->orWhere('thumbnail_img', 0)->select('id','name')->get();
        return view('backend.product.products.index', compact('products', 'qty_filter', 'sort_search', 'category_id', 'tyre_brand_id', 'categories', 'tyre_brands','products_without_imgs'));
    }

    public function create()
    {
        $data['tyre_brands'] = BrandData::where('type', 'tyre_brands')->get();
        $data['service_brands'] = BrandData::where('type', 'service_brands')->get();
        $data['size_categories'] = SizeCategory::select('id', 'name')->get();
        $data['vehicle_categories'] = VehicleCategory::select('id', 'name')->get();
        $data['feature_categories'] = FeaturedCategory::select('id', 'name')->get();
        $data['flash_deals'] = Deal::where('type', 'today')->where('status', 1)->select('id', 'title')->get();
        $data['categories'] = Category::whereIn('id', [1, 4, 5])->select('id', 'name')->get();
        $data['subcategories'] = DB::table('service_categories')->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')->select('sct.service_category_id as id', 'sct.name')->where('service_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();

        return view('backend.product.products.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'unique:products'
        ]);

        $label_icon = $request->label_status ? $request->label_status : 0;
        $return_status = $request->return_status ? $request->return_status : 0;
        $shipping_status = $request->shipping_status ? $request->shipping_status : 0;

        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        $product->user_id = \App\User::where('user_type', 'admin')->first()->id;
        $product->category_id = $request->category_id;
        if ($request->category_id == 1) {
            $product->tyre_service_brand_id = $request->tyre_brand_id;
        } else {
            $product->tyre_service_brand_id = $request->service_brand_id;
        }
        $product->featured_cat_id = $request->featured_cat_id;
        $product->featured_sub_cat_id = $request->featured_sub_cat_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_child_category_id = $request->sub_child_category_id;
        $product->vehicle_cat_id = $request->vehicle_cat_id;
        $product->size_category_id = $request->size_cat_id;
        $product->size_sub_category_id = $request->sub_cat_id;
        $product->size_child_category_id = $request->child_cat_id;
        $product->front_rear = $request->front_rear;
        $product->tyre_size = $request->tyre_size;
        $product->speed_index = $request->speed_index;
        $product->load_index = $request->load_index;
        $product->season = $request->season;
        $product->vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type : $request->vehicle_type1;
        $product->label = $request->label;
        $product->product_of = isset($request->product_of) ? $request->product_of : $request->product_of1;
        $product->warranty_type = isset($request->warranty_type) ? $request->warranty_type : $request->warranty_type1;
        $product->warranty_period = isset($request->warranty_period) ? $request->warranty_period : $request->warranty_period1;
        $product->viscosity = $request->viscosity;
        $product->packaging = $request->packaging;
        $product->service_interval = $request->service_interval;
        $product->ps_status = $request->ps_status;
        $product->photos = $request->photos;
        $product->thumbnail_img = $request->thumbnail_img;
        $product->bg_img = $request->bg_img;
        $product->label_img = $request->label_img;
        $product->label_status = $label_icon;
        $product->return_days_img = $request->return_days_img;
        $product->return_status = $return_status;
        $product->shipping_img = $request->shipping_img;
        $product->shipping_status = $shipping_status;

        $product->dry = $request->dry;
        $product->wet = $request->wet;
        $product->sport = $request->sport;
        $product->comfort = $request->comfort;
        $product->mileage = $request->mileage;

        $product->min_qty = $request->min_qty;
        $product->low_stock_quantity = $request->low_stock_quantity;
        //        $product->stock_visibility_state = $request->stock_visibility_state;

        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags = implode(',', $tags);

        $product->description = $request->description;
        $product->term_conditions = $request->term_conditions;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->unit_price       = $request->unit_price;
        $product->cost_price       = $request->cost_price;
        $product->quantity_1_price       = $request->quantity_1_price;
        $product->greater_1_price       = $request->greater_1_price;
        $product->greater_3_price       = $request->greater_3_price;
        $product->sku         = $request->sku;
        $product->qty         = $request->current_stock;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime($date_var[1]);
        }

        $product->shipping_type = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;
        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;

        if ($request->has('meta_img')) {
            $product->meta_img = $request->meta_img;
        } else {
            $product->meta_img = $product->thumbnail_img;
        }

        if ($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if ($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);
        $product->published = 1;
        if ($request->button == 'unpublish' || $request->button == 'draft') {
            $product->published = 0;
        }

        if ($request->has('featured')) {
            $product->featured = 1;
        }
        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }
        if ($request->cash_on_delivery) {
            $product->cash_on_delivery = 1;
        }
        $product->save();

        // if thumbnail image is empty and gallery has so choose one from gallery as thumbnail image
        if (is_null($product->thumbnail_img) || $product->thumbnail_img == 0) {
            if (!is_null($product->photos)) {
                $photos = explode(",", $product->photos);
                $product->thumbnail_img = $photos[0];
                $product->update();
            }
        }

        //VAT & Tax
        if ($request->tax_id) {
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax();
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }
        //Flash Deal
        if ($request->deal_id) {
            $flash_deal_product = new DealProduct();
            $flash_deal_product->deal_id = $request->deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->save();
        }

        // Product Translations
        $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
        $product_translation->name = $request->name;
        $product_translation->description = $request->description;
        $product_translation->save();

        flash(translate('Product has been inserted successfully'))->success();

        Artisan::call('view:clear');
        Artisan::call('cache:clear');

        return redirect()->route('products.all');
    }

    public function admin_product_edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data['lang'] = $request->lang;
        $data['tags'] = json_decode($product->tags);
        $data['languages'] = DB::table('languages')->select('id', 'code', 'name')->get();
        $data['categories'] = Category::whereIn('id', [1, 4, 5])->select('id', 'name')->get();
        $data['tyre_brands'] = BrandData::where('type', 'tyre_brands')->get();
        $data['service_brands'] = BrandData::where('type', 'service_brands')->get();
        $data['featured_categories'] = FeaturedCategory::select('id', 'name')->get();
        $data['featured_sub_categories'] = FeaturedSubCategory::all();
        $data['vehicle_categories'] = VehicleCategory::select('id', 'name')->get();
        $data['size_categories'] = SizeCategory::select('id', 'name')->get();
        $data['size_sub_categories'] = SizeSubCategory::all();
        $data['size_child_categories'] = SizeChildCategory::all();
        $data['flash_deals'] = Deal::where('type', 'today')->where("status", 1)->select('id', 'title')->get();
        $data['product'] = $product;
        $data['subcategories'] = DB::table('service_categories')->join('service_category_translations as sct', 'sct.service_category_id', '=', 'service_categories.id')->select('sct.service_category_id as id', 'sct.name')->where('service_categories.parent_id', null)->where('sct.lang', env('DEFAULT_LANGUAGE', 'en'))->get()->toArray();

        return view('backend.product.products.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'unique:products,name,' . $product->id,
        ]);

        $label_icon = $request->label_status ? $request->label_status : 0;
        $return_status = $request->return_status ? $request->return_status : 0;
        $shipping_status = $request->shipping_status ? $request->shipping_status : 0;

        $product->category_id       = $request->category_id;
        if ($request->category_id == 1) {
            $product->tyre_service_brand_id = $request->tyre_brand_id;
        } else {
            $product->tyre_service_brand_id = $request->service_brand_id;
        }
        $product->featured_cat_id = $request->featured_cat_id;
        $product->featured_sub_cat_id = $request->featured_sub_cat_id;
        $product->vehicle_cat_id = $request->vehicle_cat_id;
        $product->size_category_id = $request->size_cat_id;
        $product->size_sub_category_id = $request->sub_cat_id;
        $product->size_child_category_id = $request->child_cat_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->sub_child_category_id = $request->sub_child_category_id;
        $product->front_rear = $request->front_rear;
        $product->tyre_size = $request->tyre_size;
        $product->speed_index = $request->speed_index;
        $product->load_index = $request->load_index;
        $product->season = $request->season;
        $product->vehicle_type = isset($request->vehicle_type) ? $request->vehicle_type : $request->vehicle_type1;
        $product->label = $request->label;
        $product->product_of = isset($request->product_of) ? $request->product_of : $request->product_of1;
        $product->warranty_type = isset($request->warranty_type) ? $request->warranty_type : $request->warranty_type1;
        $product->warranty_period = isset($request->warranty_period) ? $request->warranty_period : $request->warranty_period1;
        $product->viscosity = $request->viscosity;
        $product->packaging = $request->packaging;
        $product->service_interval = $request->service_interval;
        $product->ps_status = $request->ps_status;
        $product->featured = 0;
        $product->todays_deal = 0;
        $product->is_quantity_multiplied = 0;

        $product->dry = $request->dry;
        $product->wet = $request->wet;
        $product->sport = $request->sport;
        $product->comfort = $request->comfort;
        $product->mileage = $request->mileage;

        if ($request->lang == env("DEFAULT_LANGUAGE")) {
            $product->name          = $request->name;
            $product->description   = $request->description;
            $product->term_conditions   = $request->term_conditions;
        }
        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5);

        $product->photos                 = $request->photos;
        $product->thumbnail_img          = $request->thumbnail_img;
        $product->bg_img = $request->bg_img;
        $product->label_img = $request->label_img;
        $product->label_status = $label_icon;
        $product->return_days_img = $request->return_days_img;
        $product->return_status = $return_status;
        $product->shipping_img = $request->shipping_img;
        $product->shipping_status = $shipping_status;

        $product->min_qty                = $request->min_qty;
        $product->low_stock_quantity     = $request->low_stock_quantity;
        //        $product->stock_visibility_state = $request->stock_visibility_state;
        $product->unit_price       = $request->unit_price;
        $product->cost_price       = $request->cost_price;
        $product->quantity_1_price       = $request->quantity_1_price;
        $product->greater_1_price       = $request->greater_1_price;
        $product->greater_3_price       = $request->greater_3_price;
        $product->sku         = $request->sku;
        $product->qty         = $request->current_stock;

        $tags = array();
        if ($request->tags[0] != null) {
            foreach (json_decode($request->tags[0]) as $key => $tag) {
                array_push($tags, $tag->value);
            }
        }
        $product->tags           = implode(',', $tags);

        $product->video_provider = $request->video_provider;
        $product->video_link     = $request->video_link;
        $product->discount       = $request->discount;
        $product->discount_type     = $request->discount_type;

        if ($request->date_range != null) {
            $date_var               = explode(" to ", $request->date_range);
            $product->discount_start_date = strtotime($date_var[0]);
            $product->discount_end_date   = strtotime($date_var[1]);
        } else {
            $product->discount_start_date = 0;
            $product->discount_end_date   = 0;
        }

        $product->shipping_type  = $request->shipping_type;
        $product->est_shipping_days  = $request->est_shipping_days;
        if ($request->has('shipping_type')) {
            if ($request->shipping_type == 'free') {
                $product->shipping_cost = 0;
            } elseif ($request->shipping_type == 'flat_rate') {
                $product->shipping_cost = $request->flat_shipping_cost;
            } elseif ($request->shipping_type == 'product_wise') {
                $product->shipping_cost = json_encode($request->shipping_cost);
            }
        }

        if ($request->has('is_quantity_multiplied')) {
            $product->is_quantity_multiplied = 1;
        }
        if ($request->has('cash_on_delivery')) {
            $product->cash_on_delivery = 1;
        }

        if ($request->has('featured')) {
            $product->featured = 1;
        }

        if ($request->has('todays_deal')) {
            $product->todays_deal = 1;
        }

        $product->meta_title        = $request->meta_title;
        $product->meta_description  = $request->meta_description;
        $product->meta_img          = $request->meta_img;

        if ($product->meta_title == null) {
            $product->meta_title = $product->name;
        }

        if ($product->meta_description == null) {
            $product->meta_description = strip_tags($product->description);
        }

        if ($product->meta_img == null) {
            $product->meta_img = $product->thumbnail_img;
        }
        $product->save();

        // if thumbnail image is empty and gallery has so choose one from gallery as thumbnail image
        if (is_null($product->thumbnail_img) || $product->thumbnail_img == 0) {
            if (!is_null($product->photos)) {
                $photos = explode(",", $product->photos);
                $product->thumbnail_img = $photos[0];
                $product->update();
            }
        }

        //Flash Deal
        if ($request->deal_id) {
            if ($product->deal_product) {
                $flash_deal_product = DealProduct::findOrFail($product->deal_product->id);
            }
            if (!$flash_deal_product) {
                $flash_deal_product = new DealProduct;
            }
            $flash_deal_product->deal_id = $request->deal_id;
            $flash_deal_product->product_id = $product->id;
            $flash_deal_product->save();
        }

        //VAT & Tax
        if ($request->tax_id) {
            ProductTax::where('product_id', $product->id)->delete();
            foreach ($request->tax_id as $key => $val) {
                $product_tax = new ProductTax;
                $product_tax->tax_id = $val;
                $product_tax->product_id = $product->id;
                $product_tax->tax = $request->tax[$key];
                $product_tax->tax_type = $request->tax_type[$key];
                $product_tax->save();
            }
        }

        // Product Translations
        $product_translation                = ProductTranslation::firstOrNew(['lang' => $request->lang, 'product_id' => $product->id]);
        $product_translation->name          = $request->name;
        $product_translation->description   = $request->description;
        $product_translation->save();

        flash(translate('Product has been updated successfully'))->success();
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        return back();
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        foreach ($product->product_translations as $key => $product_translations) {
            $product_translations->delete();
        }

        if (Product::destroy($id)) {
            DB::table('carts')->where('product_id', $id)->delete();
            DB::table('browse_histories')->where('product_type', '!=', 'battery')->where('product_id', $id)->delete();
            flash(translate('Product has been deleted successfully'))->success();
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            return back();
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function bulk_product_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $product_id) {
                $this->destroy($product_id);
            }
        }
        return 1;
    }

    public function duplicate(Request $request, $id)
    {
        $product = Product::find($id);
        $product_new = $product->replicate();
        $product_new->name = $product->name . ' - 1';
        $product_new->slug = substr($product_new->slug, 0, -5) . Str::random(5);

        if ($product_new->save()) {
            // Product Translations
            $product_trans = ProductTranslation::where('product_id', $id)->first();
            $product_new_trans = $product_trans->replicate();
            $product_new_trans->product_id = $product_new->id;
            $product_new_trans->name = $product_new->name;
            $product_new_trans->save();
            flash(translate('Product has been duplicated successfully'))->success();
            return redirect()->route('products.all');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function clear_product(Request $request)
    {
        $product = Product::find(decrypt($request->id));
        $product->brand_id = null;
        $product->model_id = null;
        $product->year_id = null;
        $product->variant_id = null;
        $product->save();
        flash(translate('Product has been cleared successfully'))->success();
        return redirect()->route('products.all');
    }

    public function updatePublished(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->published = $request->status;
        $product->save();
        return 1;
    }

    public function updateFeatured(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $product->featured = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    public function ajaxm(Request $request)
    {
        $html = '<option value="">--Select--</option>';
        if ($request->has('id')) {
            $selected_models = [];
            if ($request->has('models')) {
                $selected_models = explode(',', $request->models);
            }
            $ids = (is_array($request->id)) ? $request->id : [$request->id];
            $models = CarModel::select('id', 'name')->orderBy('name', 'asc')->whereIn('brand_id', $ids)->get();
            foreach ($models as $model) {
                $selected = (in_array($model->id, $selected_models)) ? 'selected' : '';
                $html .= '<option value="' . $model->id . '"' . $selected . '>' . $model->name . '</option>';
            }
        }
        return $html;
    }

    public function ajaxy(Request $request)
    {
        $html = '<option value="">--Select--</option>';
        if ($request->has('id')) {
            $selected_caryears = [];
            if ($request->has('caryears')) {
                $selected_caryears = explode(',', $request->caryears);
            }
            $ids = (is_array($request->id)) ? $request->id : [$request->id];
            $years = CarYear::select('id', 'name')->orderBy('name', 'asc')->whereIn('model_id', $ids)->get();
            foreach ($years as $year) {
                $selected = (in_array($year->id, $selected_caryears)) ? 'selected' : '';
                $html .= '<option value="' . $year->id . '"' . $selected . '>' . $year->name . '</option>';
            }
        }

        return $html;
    }

    public function ajaxv(Request $request)
    {
        $html = '<option value="">--Select--</option>';
        if ($request->has('id')) {
            $selected_car_variants = [];
            if ($request->has('car_variants')) {
                $selected_car_variants = explode(',', $request->car_variants);
            }
            $ids = (is_array($request->id)) ? $request->id : [$request->id];
            $variants = CarVariant::select('id', 'name')->orderBy('name', 'asc')->whereIn('year_id', $ids)->get();
            foreach ($variants as $variant) {
                $selected = (in_array($variant->id, $selected_car_variants)) ? 'selected' : '';
                $html .= '<option value="' . $variant->id . '"' . $selected . '>' . $variant->name . '</option>';
            }
        }

        return $html;
    }

    public function products_groups()
    {
        $product_groups = DB::table('product_groups')->orderBy('id', 'desc')->paginate(10);
        return view('backend.product.groups.index', compact('product_groups'));
    }

    public function all_products_groups(Request $request)
    {
        $sort_search = null;
        $products = Product::where('category_id', 4)->where('qty', '>', 0);
        if ($request->search != null) {
            $products = $products
                ->where('products.name', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }
        $products = $products->select('products.id', 'products.name', 'products.thumbnail_img')->paginate(20);
        return view('backend.product.groups.products.index', compact('products', 'sort_search'));
    }

    public function export($type)
    {
        if ($type == 'tyre') {
            return Excel::download(new TyreProductsExport, 'tyre_products.xlsx');
        } else {
            return Excel::download(new ServiceProductsExport, 'service_products.xlsx');
        }
    }

    public function updateImage(Request $request)
    {
        foreach($request->products as $product_id){
            $product = Product::find($product_id);
            $product->thumbnail_img = $request->thumbnail_img;
            $product->update();
        }
        flash(translate('Product image has been saved successfully'))->success();
        return back();
    }
}
