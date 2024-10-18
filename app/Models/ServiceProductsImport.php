<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductTranslation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

//class ServiceProductsImport implements ToModel, WithHeadingRow, WithValidation
class ServiceProductsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;

    public function collection(Collection $rows) {
            foreach ($rows as $row) {
                // $image = $this->downloadThumbnail($row['thumbnail_img']);
                $product_exists = Product::where('name',$row['name'])->first();
                if(!$product_exists){
                $product = new Product();
                $product->name = $row['name'];
                $product->added_by = 'admin';
                $product->user_id = Auth::user()->id;
                $product->ategory_id = $row['category_id'];
                $product->min_qty = $row['minimum_purchase_qty'];
                $product->tyre_service_brand_id = $row['service_brand'];
                $product->video_provider = $row['video_provider'];
                $product->video_link = $row['video_link'];
                $product->cost_price = $row['cost_price'];
                $product->unit_price = $row['unit_price'];
                $product->discount = $row['discount'];
                $product->discount_type = 'amount';
                $product->qty = $row['qty'];
                $product->sku = $row['sku'];
                $product->sub_category_id = $row['sub_category_id'];
                $product->sub_child_category_id = $row['sub_child_category_id'];
                $product->viscosity = $row['viscosity'];
                $product->packaging = $row['packaging'];
                $product->vehicle_type = $row['vehicle_type'];
                $product->service_interval = $row['service_interval'];
                $product->product_of = $row['product_of'];
                $product->warranty_type = $row['warranty_type'];
                $product->warranty_period = $row['warranty_period'];
                $product->low_stock_quantity = $row['low_stock_quantity'];
                $product->featured = $row['featured'];
                $product->meta_title = $row['name'];
                $product->meta_description = $row['name'];
                $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $row['name'])) . '-' . Str::random(5);
                // $product->thumbnail_img = $image;
                // $product->meta_img = $image;
                $product->save();
                // Product Translations
                $product_translation = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product->id]);
                $product_translation->name = $row['name'];
                $product_translation->description = $row['name'];
                $product_translation->save();
            }
            else{
                $product_exists->category_id = $row['category_id'];
                $product_exists->min_qty = $row['minimum_purchase_qty'];
                $product_exists->tyre_service_brand_id = $row['service_brand'];
                $product_exists->video_provider = $row['video_provider'];
                $product_exists->video_link = $row['video_link'];
                $product_exists->cost_price = $row['cost_price'];
                $product_exists->unit_price = $row['unit_price'];
                $product_exists->discount = $row['discount'];
                $product_exists->qty = $row['qty'];
                $product_exists->sku = $row['sku'];
                $product_exists->sub_category_id = $row['sub_category_id'];
                $product_exists->sub_child_category_id = $row['sub_child_category_id'];
                $product_exists->viscosity = $row['viscosity'];
                $product_exists->packaging = $row['packaging'];
                $product_exists->vehicle_type = $row['vehicle_type'];
                $product_exists->service_interval = $row['service_interval'];
                $product_exists->product_of = $row['product_of'];
                $product_exists->warranty_type = $row['warranty_type'];
                $product_exists->warranty_period = $row['warranty_period'];
                $product_exists->low_stock_quantity = $row['low_stock_quantity'];
                $product_exists->featured = $row['featured'];
                // If thumbnail image is empty and gallery has so will choose one of the gallery as thumbnail image
                if(is_null($product_exists->thumbnail_img) || $product_exists->thumbnail_img == 0){
                    if(!is_null($product_exists->photos)){
                      $photos = explode(",", $product_exists->photos);
                      $product_exists->thumbnail_img = $photos[0];
                    }
                }
                // $product_exists->thumbnail_img = $image;
                // $product_exists->meta_img = $image;
                $product_exists->update();

                // Product Translations
                $product_translation                = ProductTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'product_id' => $product_exists->id]);
                $product_translation->name          = $row['name'];
                $product_translation->save();
            }
        }

        flash(translate('Products imported successfully'))->success();
    }

    public function model(array $row)
    {
        ++$this->rows;
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
        return [
             // Can also use callback validation rules
            //  'unit_price' => function($attribute, $value, $onFailure) {
            //       if (!is_numeric($value)) {
            //            $onFailure('Unit price is not numeric');
            //       }
            //   }
        ];
    }

    public function downloadThumbnail($url){
        if($url){
        try {
            $extension = pathinfo($url, PATHINFO_EXTENSION);
            $filename = 'uploads/all/'.Str::random(15).'.'.$extension;
            $fullpath = 'public/'.$filename;
            $file = file_get_contents($url);
            file_put_contents($fullpath, $file);

            $upload = new Upload;
            $upload->extension = strtolower($extension);
            $upload->file_original_name = $filename;
            $upload->file_name = $filename;
            $upload->user_id = Auth::user()->id;
            $upload->type = "image";
            $upload->file_size = filesize(base_path($fullpath));
            $upload->save();

        return $upload->id;
        } catch (\Exception $e) {
            //dd($e);
        }
    }
        return 0;
    }
}
