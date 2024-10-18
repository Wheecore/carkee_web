<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ServiceProductsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
       return Product::where('category_id', 4)->select('id','name','category_id','brand_id','model_id','min_qty','tyre_service_brand_id',
       'video_provider','video_link','cost_price','unit_price','discount','qty','sku','sub_category_id','sub_child_category_id','viscosity',
       'packaging','vehicle_type','service_interval','product_of','warranty_type','warranty_period','low_stock_quantity','featured','thumbnail_img')
       ->get();
    }

    public function headings(): array
    {
        return [
            'name',
            'category_id',
            'brands',
            'models',
            'minimum_purchase_qty',
            'service_brand',
            'video_provider',
            'video_link',
            'cost_price',
            'unit_price',
            'discount',
            'qty',
            'sku',
            'sub_category_id',
            'sub_child_category_id',
            'viscosity',
            'packaging',
            'vehicle_type',
            'service_interval',
            'product_of',
            'warranty_type',
            'warranty_period',
            'low_stock_quantity',
            'featured',
            // 'thumbnail_img'
        ];
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->category_id,
            $product->brand_id,
            $product->model_id,
            $product->min_qty,
            $product->tyre_service_brand_id,
            $product->video_provider,
            $product->video_link,
            number_format($product->cost_price, 0),
            number_format($product->unit_price, 0),
            number_format($product->discount, 0),
            $product->qty,
            $product->sku,
            $product->sub_category_id,
            $product->sub_child_category_id,
            $product->viscosity,
            $product->packaging,
            $product->vehicle_type,
            $product->service_interval,
            $product->product_of,
            $product->warranty_type,
            $product->warranty_period,
            $product->low_stock_quantity,
            number_format($product->featured, 0),
            // uploaded_asset($product->thumbnail_img)
        ];
    }
}
