<?php

namespace App\Models;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class GiftCodesExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{

protected $date;

    function __construct($date) {
        $this->date = $date;
    }

    public function collection()
    {
        $codes = GiftCode::where('type', 'car_wash');
        if ($this->date != null) {
            $exploded_date = explode(" to ", $this->date);
            $codes = $codes->whereDate('created_at', '>=', date('Y-m-d', strtotime($exploded_date[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime($exploded_date[1])));
        }
        $codes = $codes->select('code','category','start_date','end_date','discount_amount')->get();
        return $codes;
    }

    public function headings(): array
    {
        return [
            'Code',
            'Category',
            'Start Date',
            'End Date',
            'Discount Amount'
        ];
    }

    public function map($code): array
    {
        return [
            $code->code,
            ucfirst(str_replace("_"," ",$code->category)),
            date(env('DATE_FORMAT'), $code->start_date),
            date(env('DATE_FORMAT'), $code->end_date),
            format_price($code->discount_amount)
        ];
    }
}
