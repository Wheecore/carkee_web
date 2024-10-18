<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class MerchantVoucher extends Model
{
    protected $fillable = ['merchant_id','voucher_code', 'total_limit', 'used_count','used_by','amount','description'];

    public function merchant()
    {
        return $this->belongsTo(User::class);
    }
}
