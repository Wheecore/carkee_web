<?php

namespace App\Http\Controllers\Api\V2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\User;
use App\Models\MerchantVoucher;
use App\Models\QrcodeDownloadHistory;
use App\Models\Upload;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MerchantController extends Controller
{
    public function frontMerchants(Request $request)
    {
        $geolocation = new \stdClass();
        $geolocation->address = $request->address;
        $geolocation->latitude = $request->latitude;
        $geolocation->longitude = $request->longitude;
        $radius = $request->radius;
        $category = $request->category;
        if (empty($radius) && $radius == '') $radius = 25;
        $merchants = $this->getNearbyMerchants($radius, $category, $geolocation->address, $geolocation->latitude, $geolocation->longitude);
        $merchants = collect($merchants);
        $first_loop = false;
        $normal_first_loop = false;
        $recommended_stores = $merchants->map(function($merchant) use($first_loop){
            $merchantt = User::find($merchant->id);
            $shop = $merchantt->shop;
            if($merchantt->is_recommended == 1){
            $first_loop = true;
            return [
                    'shop_name' => $shop->name?$shop->name:'',
                    'merchant_id' => $shop->user_id,
                    'shop_logo' => ($merchantt->shop->logo !== null) ? api_asset($shop->logo) : static_asset('assets/img/placeholder.jpg'),
                    'shop_address' => $shop->address?$shop->address:''
                   ];
            }
            else if(!$first_loop){
               return [];
            }
        });

        $normal_stores = $merchants->map(function($merchant) use($normal_first_loop){
            $merchantt = User::find($merchant->id);
            $shop = $merchantt->shop;
            if($merchantt->is_recommended == 0){
            $normal_first_loop = true;
            return [
                    'shop_name' => $shop->name,
                    'merchant_id' => $shop->user_id,
                    'shop_logo' => ($merchantt->shop->logo !== null) ? api_asset($shop->logo) : static_asset('assets/img/placeholder.jpg'),
                    'shop_address' => $shop->address?$shop->address:''
                   ];
            }
            else if(!$normal_first_loop){
               return [];
            }
        });

        $merchant_categories = DB::table('merchant_categories')->get();
        $merchant_categories_arr = $merchant_categories->map(function($merchant_category){
            return [
                    'id' => $merchant_category->id,
                    'name' => $merchant_category->name
                   ];
        });
         return response()->json([
            'result' => true,
            'total_merchants' => count($merchants),
            'recommended_stores' => $recommended_stores,
            'normal_stores' => $normal_stores,
            'merchant_categories' => $merchant_categories_arr
        ]);
    }

    private function getNearbyMerchants($radius, $category, $address, $latitude, $longitude)
    {
        $merchants = array();
        if ($address && $latitude && $longitude) {
            if ($latitude != 0 && $longitude != 0) {
                    if($category == 'all'){
                        $datas = User::join('shops', 'users.id', '=', 'shops.user_id')
                            ->where('users.user_type', '=', 'merchant')
                            ->select('shops.latitude', 'shops.longitude', 'users.id');
                    }
                    else{
                        $datas = User::join('shops', 'users.id', '=', 'shops.user_id')
                            ->where('users.user_type', '=', 'merchant')
                            ->where('users.merchant_category', $category)
                            ->select('shops.latitude', 'shops.longitude', 'users.id');
                    }
                    $datas = $datas->orderBy('shops.id', 'desc')->get();
                    foreach ($datas as $data) {
                        $distance = $this->distance($data->latitude, $data->longitude, $latitude, $longitude, 'K');
                        if ($distance <= 50) {
                            $data->distance = $distance;
                            if ($distance <= $radius) {
                                $merchants[] = $data;
                            }
                        }
                    }              
            }
        }
        return $merchants;
    }

    private function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public function getMerchantVouchers(Request $request, $user_id = null)
    {
        if($user_id != null){
            $user_id = (integer) $user_id;
            $m_vouchers = MerchantVoucher::where('merchant_id',$request->merchant_id)->whereRaw('total_limit > used_count')->whereJsonDoesntContain('used_by', $user_id)->get();
        }
        else{
            $m_vouchers = MerchantVoucher::where('merchant_id',$request->merchant_id)->whereRaw('total_limit > used_count')->get();
        }
        $shop_name = $request->shop_name;
        $vouchers_arr = $m_vouchers->map(function($m_voucher){
               return [
                     'voucher_id' => $m_voucher->id,
                     'image' => ($m_voucher->image !== null) ? api_asset($m_voucher->image) : static_asset('assets/img/placeholder.jpg'),
                     'voucher_code' => $m_voucher->voucher_code,
                     'amount' => single_price($m_voucher->amount).' OFF'
                     ];
        });
        return response()->json([
        'result' => true,
        'vouchers_count' => count($m_vouchers),
        'vouchers' => $vouchers_arr,
        'shop_name' => $shop_name?$shop_name:''
    ]);
    }

    public function voucherDetails($voucher_id, $user_email){
        $voucher = MerchantVoucher::find($voucher_id);

        $imageName = 'qr-code-'.$voucher->voucher_code.'-'.$user_email.'.png';
        if(!file_exists(public_path().'/qr-codes/'.$imageName)){
        $type = 'png';
        $string = "Voucher Code: ".$voucher->voucher_code."\n";
        $string.= "User Email: ".$user_email;
        \QrCode::format($type)
            ->size(200)->errorCorrection('H')
            ->margin(2)
            ->generate($string, public_path().'/qr-codes/'.$imageName);
        }
        return response()->json([
            'result' => true,
            'voucher_code' => $voucher->voucher_code?$voucher->voucher_code:'',
            'image' => ($voucher->image !== null) ? api_asset($voucher->image) : static_asset('assets/img/placeholder.jpg'),
            'amount' => $voucher->amount?single_price($voucher->amount):'RM0.00',
            'description' => $voucher->description?$voucher->description:'',
            'qrcode_image_name' => $imageName,
            'qr_code_link' => url('public/qr-codes/'.$imageName)
        ]);
    }

    public function merchantVoucherQRcodeDownload(Request $request, $user_id)
    {
        $record_exists = QrcodeDownloadHistory::where('voucher_code',$request->voucher_code)->where('user_id',$user_id)->first();
        if(!$record_exists){
        $download_history = new QrcodeDownloadHistory();
        $download_history->user_id = $user_id;
        $download_history->voucher_code = $request->voucher_code;
        $download_history->image_name = $request->image_name;
        $download_history->save();
        }
        return response()->json([
            'result' => true,
            'qr_code_link' => url('public/qr-codes/'.$request->image_name),
            'qr_code_name' => 'qr-code-'.time().'.png'
        ]);
    }

    public function dashboard($user_id)
    {
    if($user_id){
        $merchant_vouchers = MerchantVoucher::where('merchant_id', $user_id)->orderBy('created_at', 'desc')->get();
        $merchant_vouchers_arr = $merchant_vouchers->map(function($voucher) use($user_id){
            return [
                   'voucher_code' => $voucher->voucher_code?$voucher->voucher_code:'',
                   'used_limit' => $voucher->total_limit?$voucher->total_limit:0,
                   'no_of_used' => $voucher->used_count?$voucher->used_count:0,
                   'amount' => $voucher->amount?single_price($voucher->amount):'',
                   'creation_date' => $voucher->created_at ? convert_datetime_to_local_timezone($voucher->created_at, user_timezone($user_id)) : ''
                  ];
        });
        return response()->json([
            'result' => true,
            'merchant_vouchers' => $merchant_vouchers_arr
        ]);
        }
        else{
            return response()->json([
            'result' => false,
            'message' => 'You are logged out from app please login again.'
        ]);
        }
    }

    public function checkVoucher($merchant_id, $voucher_code, $user_email){
        $user = User::where('email',$user_email)->select('id','user_type')->first();
        if($user && $user->user_type == 'customer'){
            $user_id = $user->id;
            $merchant_voucher = MerchantVoucher::where('merchant_id',$merchant_id)->where('voucher_code', $voucher_code)->whereJsonDoesntContain('used_by', $user_id)->first();
            if (!$merchant_voucher) {
            return response()->json([
                'result' => false,
                'amount' => '',
                'message' => 'Voucher code is invalid.'
            ]);
            }
            else if($merchant_voucher && $merchant_voucher->used_count >= $merchant_voucher->total_limit){
            return response()->json([
                'result' => false,
                'amount' => '',
                'message' => 'This voucher code limit is already fulled.'
            ]);
            }
            else{
                $used_by = $merchant_voucher->used_by;
                if($used_by == '[]'){
                    $used_by = '['.$user_id.']';
                }
                else{
                    $used_by = str_replace("]","",$used_by);
                    $used_by = $used_by.','.$user_id.']';
                }
                $merchant_voucher->update([
                    'used_count' => $merchant_voucher->used_count+1,
                    'used_by' => $used_by
                ]);
                return response()->json([
                    'result' => true,
                    'amount' => single_price($merchant_voucher->amount),
                    'message' => 'Voucher code has been successfully used against this user.'
                ]);
            }
        }
        else{
            return response()->json([
                'result' => false,
                'amount' => '',
                'message' => 'The user email address is invalid.'
            ]);
        }
    }

    public function shopData($user_id)
    {
        $user = User::find($user_id);
        $shop = $user->shop;
        $cats_arr = [];
        if($shop && $shop->category_id){
        $cats = json_decode($shop->category_id);
        $cats = collect($cats);
        $cats_arr = $cats->map(function($cat){
            $category = Category::where('id', $cat)->first();
            return [
                   'category_name' => $category->name?$category->name:''
                   ];
        });
        }
        return response()->json([
            'result' => true,
            'id' => ($shop)?$shop->id:0,
            'shop_name' => ($shop && $shop->name)?$shop->name:'',
            'logo' => ($shop && $shop->logo)?api_asset($shop->logo):'',
            'phone' => ($shop && $shop->phone)?$shop->phone:'',
            'address' => ($shop && $shop->address)?$shop->address:'',
            'latitude' => ($shop && $shop->latitude)?$shop->latitude:'',
            'longitude' => ($shop && $shop->longitude)?$shop->longitude:'',
            'categories' => $cats_arr
        ]);
    }

    public function updateShopInfo(Request $request, $shop_id, $user_id)
    {
        $shop = Shop::find($shop_id);
        $shop->name = $request->name;
        $shop->latitude = $request->latitude;
        $shop->longitude = $request->longitude;
        $shop->address = $request->address;
        $shop->phone = $request->phone;
        $shop->slug = preg_replace('/\s+/', '-', $request->name).'-'.$shop->id;

        if($request->hasfile('logo')){
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
        );
        $dir = public_path('uploads/all/');
        $file = $request->file('logo');
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace(" ", "-", rand(10000000000,9999999999).date("YmdHis").$file->getClientOriginalName());

        $upload = new Upload;
        $size = $file->getSize();

        if (!isset($type[$extension])) {
            return response()->json([
                'result' => false,
                'message' => "Only image can be uploaded"
            ]);
        }

        $newPath = "uploads/all/$filename";
        if (env('FILESYSTEM_DRIVER') == 's3') {
            Storage::disk('s3')->put($newPath, file_get_contents(base_path('public/') . $newPath));
        }
        else{
            $file->move($dir,$filename);
        }

        $upload->file_original_name = 'shop_logo';
        $upload->extension = $extension;
        $upload->file_name = 'uploads/all/'.$filename;
        $upload->user_id = $user_id;
        $upload->type = $type[$upload->extension];
        $upload->file_size = $size;
        $upload->save();

        $logo = $upload->id;
        }
        else{
            $logo = $shop->logo;
        }
        $shop->logo = $logo;

        if($shop->save()){
        return response()->json([
            'result' => true,
            'message' => 'Your Shop has been updated successfully!',
        ]);
        }

        return response()->json([
            'result' => false,
            'message' => 'Sorry! Something went wrong.',
        ]);
    }

}
