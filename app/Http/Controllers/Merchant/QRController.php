<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QRController extends Controller
{
    public function scanVoucherQrcode()
    {
        return view('frontend.user.scan_voucher_qrcode');
    }
}
