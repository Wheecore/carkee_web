<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\Order;
use App\Models\Upload;
use App\User;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function counters($user_id)
    {
        return response()->json([
            'cart_item_count' => Cart::where('user_id', $user_id)->count(),
            'order_count' => Order::where('user_id', $user_id)->count(),
        ]);
    }

    public function profilePage($user_id)
    {
        $user = User::find($user_id);
        return response()->json([
            'result' => true,
            'name' => $user->name?$user->name:'',
            'email' => $user->email?$user->email:'',
            'phone' => $user->phone?$user->phone:'',
            'photo' => $user->avatar_original?api_asset($user->avatar_original):'',
            'bank_name' => ($user->seller && $user->seller->bank_name)?$user->seller->bank_name:'',
            'bank_acc_name' => ($user->seller && $user->seller->bank_acc_name)?$user->seller->bank_acc_name:'',
            'bank_acc_no' => ($user->seller && $user->seller->bank_acc_no)?$user->seller->bank_acc_no:''
        ]);
    }

    public function profileUpdate(Request $request, $user_id)
    {
        $email_exists = User::where('email',$request->email)->where('id', '!=', $user_id)->first();
        if($email_exists){
        return response()->json([
            'result' => false,
            'message' => 'Email already exists!',
        ]);
        }
        $user = User::find($user_id);
        if($request->hasfile('photo')){
        $type = array(
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
        );
        $dir = public_path('uploads/all/');
        $file = $request->file('photo');
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

        $upload->file_original_name = 'profile';
        $upload->extension = $extension;
        $upload->file_name = 'uploads/all/'.$filename;
        $upload->user_id = $user_id;
        $upload->type = $type[$upload->extension];
        $upload->file_size = $size;
        $upload->save();

        $photo = $upload->id;
        }
        else{
            $photo = $user->avatar_original;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->new_password != "" && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $photo;
        if($user->save()) {
        return response()->json([
            'result' => true,
            'message' => 'Your Profile has been updated successfully!',
        ]);
        }
       return response()->json([
            'result' => false,
            'message' => 'Sorry! Something went wrong.',
        ]);
    }

}
