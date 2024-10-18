<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TyreProductsExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        return Product::where('category_id', 1)->select('id','name','category_id','brand_id','model_id','min_qty','tyre_service_brand_id',
        'video_provider','video_link','cost_price','quantity_1_price','greater_1_price','greater_3_price','discount','qty','sku','tyre_size','speed_index',
        'load_index','season','vehicle_type','label','product_of','warranty_type','warranty_period','low_stock_quantity','featured','thumbnail_img')
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
            'tyre_brand',
            'video_provider',
            'video_link',
            'cost_price',
            'qty_1_price',
            'qty_greater_1_price',
            'qty_greater_3_price',
            'discount',
            'qty',
            'sku',
            'tyre_size',
            'speed_index',
            'load_index',
            'season',
            'vehicle_type',
            'label',
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
            number_format($product->quantity_1_price, 0),
            number_format($product->greater_1_price, 0),
            number_format($product->greater_3_price, 0),
            number_format($product->discount, 0),
            $product->qty,
            $product->sku,
            $product->tyre_size,
            $product->speed_index,
            $product->load_index,
            $product->season,
            $product->vehicle_type,
            $product->label,
            $product->product_of,
            $product->warranty_type,
            $product->warranty_period,
            $product->low_stock_quantity,
            number_format($product->featured, 0),
            // uploaded_asset($product->thumbnail_img)
        ];
    }
}
