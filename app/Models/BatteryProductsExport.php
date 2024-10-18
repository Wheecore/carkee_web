<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BatteryProductsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Battery::where('service_type','N')->select('name','car_brand_id','car_model_id','warranty','model',
        'amount','discount','stock','capacity','cold_cranking_amperes','mileage_warranty','sub_category_id','sub_child_category_id',
        'reserve_capacity','height','length','width','start_stop_function','jis','absorbed_glass_mat','attachment_id','battery_brand_id')
        ->get();
    }

    public function headings(): array
    {
        return [
        'name',
        'car_brand_id',
        'car_model_id',
        'battery_brand_id',
        'sub_category_id',
        'sub_child_category_id',
        'warranty_period',
        'battery_model',
        'unit_price',
        'discount',
        'quantity',
        'capacity',
        'cold_craking_amperes',
        'mileage_warranty',
        'reserve_capacity',
        'height',
        'length',
        'width',
        'start_stop_function',
        'jis',
        'absorbed_glass_mat',
        // 'thumbnail_img'
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->car_brand_id,
            $product->car_model_id,
            $product->battery_brand_id,
            $product->sub_category_id,
            $product->sub_child_category_id,
            $product->warranty,
            $product->model,
            $product->amount,
            $product->discount,
            $product->stock,
            $product->capacity,
            $product->cold_cranking_amperes,
            $product->mileage_warranty,
            $product->reserve_capacity,
            $product->height,
            $product->length,
            $product->width,
            $product->start_stop_function,
            $product->jis,
            $product->absorbed_glass_mat,
            // uploaded_asset($product->attachment_id)
        ];
    }
}
