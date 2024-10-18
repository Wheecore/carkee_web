<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;

class BatteryProductsImport implements ToCollection, WithHeadingRow, WithValidation, ToModel
{
    private $rows = 0;

    public function collection(Collection $rows) {
            foreach ($rows as $row) {
                // $image = $this->downloadThumbnail($row['thumbnail_img']);
                $battery_exists = Battery::where('name',$row['name'])->first();
                if(!$battery_exists){
                $battery = new Battery();
                $battery->name = $row['name'];
                $battery->user_id = Auth::user()->id;
                $battery->service_type = 'N';
                $battery->battery_brand_id = $row['battery_brand_id'];
                $battery->sub_category_id = $row['sub_category_id'];
                $battery->sub_child_category_id = $row['sub_child_category_id'];
                $battery->warranty = $row['warranty_period'];
                $battery->model = $row['battery_model'];
                $battery->amount = $row['unit_price'];
                $battery->discount = $row['discount'];
                $battery->stock = $row['quantity'];
                $battery->capacity = $row['capacity'];
                $battery->cold_cranking_amperes = $row['cold_craking_amperes'];
                $battery->mileage_warranty = $row['mileage_warranty'];
                $battery->reserve_capacity = $row['reserve_capacity'];
                $battery->height = $row['height'];
                $battery->length = $row['length'];
                $battery->width = $row['width'];
                $battery->start_stop_function = $row['start_stop_function'];
                $battery->jis = $row['jis'];
                $battery->absorbed_glass_mat = $row['absorbed_glass_mat'];
                // $battery->attachment_id = $image;
                $battery->save();
            }
            else{
                $battery_exists->battery_brand_id = $row['battery_brand_id'];
                $battery_exists->sub_category_id = $row['sub_category_id'];
                $battery_exists->sub_child_category_id = $row['sub_child_category_id'];
                $battery_exists->warranty = $row['warranty_period'];
                $battery_exists->model = $row['battery_model'];
                $battery_exists->amount = $row['unit_price'];
                $battery_exists->discount = $row['discount'];
                $battery_exists->stock = $row['quantity'];
                $battery_exists->capacity = $row['capacity'];
                $battery_exists->cold_cranking_amperes = $row['cold_craking_amperes'];
                $battery_exists->mileage_warranty = $row['mileage_warranty'];
                $battery_exists->reserve_capacity = $row['reserve_capacity'];
                $battery_exists->height = $row['height'];
                $battery_exists->length = $row['length'];
                $battery_exists->width = $row['width'];
                $battery_exists->start_stop_function = $row['start_stop_function'];
                $battery_exists->jis = $row['jis'];
                $battery_exists->absorbed_glass_mat = $row['absorbed_glass_mat'];
                // $battery_exists->attachment_id = $image;
                $battery_exists->update();
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
             'unit_price' => function($attribute, $value, $onFailure) {
                  if (!is_numeric($value)) {
                       $onFailure('Unit price is not numeric');
                  }
              }
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
        //     //dd($e);
        }
    }
        return 0;
    }
}
