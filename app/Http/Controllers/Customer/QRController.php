<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\QrcodeDownloadHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class QRController extends Controller
{
    public function History(Request $request)
    {
        $sort_search = null;
        $download_histories = QrcodeDownloadHistory::where('user_id', Auth::id())->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $sort_search = $request->search;
            $voucher_ids = QrcodeDownloadHistory::where(function ($voucher) use ($sort_search) {
                $voucher->where('voucher_code', 'like', '%' . $sort_search . '%');
            })->pluck('id')->toArray();
            $download_histories = $download_histories->where(function ($voucher) use ($voucher_ids) {
                $voucher->whereIn('id', $voucher_ids);
            });
        }
        $download_histories = $download_histories->paginate(15);
        return view('frontend.user.qrdownload_history', compact('download_histories', 'sort_search'));
    }

    public function ViewAgain(Request $request)
    {
        $voucher = QrcodeDownloadHistory::find($request->id);
        $string = "Voucher Code: " . $voucher->voucher_code . "\n";
        $string .= "User Email: " . Auth::user()->email;
        return view('frontend.partials.view_qrcode_again', compact('string'));
    }

    public function downloadMerchantVoucherQrcode(Request $request, $type)
    {
        $imageName = 'qr-code-web'.$request->voucher_code.'-'.Auth::user()->email.'.png';
        if(!file_exists(public_path().'/qr-codes/'.$imageName)){
        $type = 'png';
        $string = "Voucher Code: ".$request->voucher_code."\n";
        $string.= "User Email: ".Auth::user()->email;
        \QrCode::format($type)
            ->size(200)->errorCorrection('H')
            ->margin(2)
            ->generate($string, public_path().'/qr-codes/'.$imageName);
        }

        $record_exists = QrcodeDownloadHistory::where('voucher_code', $request->voucher_code)->where('user_id', Auth::id())->first();
        if (!$record_exists) {
            $download_history = new QrcodeDownloadHistory();
            $download_history->user_id = Auth::id();
            $download_history->voucher_code = $request->voucher_code;
            $download_history->image_name = $imageName;
            $download_history->save();
        }
        
        return response()->download(public_path('qr-codes/'.$imageName)); 
    }
}
