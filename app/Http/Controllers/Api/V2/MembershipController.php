<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MembershipController extends Controller
{
    public function check_family_member(Request $request)
    {
        $user = User::where('email', $request->email)->where('user_type', 'customer')->where('banned', 0)->first();
        $login_user = User::where('id', $request->user_id)->select('parent_id')->first();
        if($user){
        if($user->parent_id == 0){
            if($login_user->parent_id != $user->id){
                $user_data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'thumbnail_image' => api_asset($user->avatar_original)
                ];
                return response()->json([
                    'result' => true,
                    'data' => $user_data,
                ]);
            }
            else{
                return response()->json([
                    'result' => false,
                    'message' => "Sorry! You can't add father as a child",
                ]);
            }
        }
        else{
            return response()->json([
                'result' => false,
                'message' => 'Sorry! This email address is already added in other family',
            ]);
        }
       }
       else{
        return response()->json([
            'result' => false,
            'message' => 'Sorry! User with this email address is not present in system',
        ]);
       }
    }

    public function add_family_member(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $user->parent_id = $request->user_id;
        $user->update();
        return response()->json([
            'result' => true,
            'message' => 'Added successfully',
        ]);
    }

    public function family_members(Request $request)
    {
      $user_ids = User::where('parent_id', $request->user_id)->get()->pluck('id'); 
      // getting parent of login user if have
      $login_user = DB::table('users')->where('id', $request->user_id)->select('parent_id')->first();
      if($login_user->parent_id){
        $user_ids[] = $login_user->parent_id;
      }
      
      $users = User::whereIn('users.id', $user_ids)
      ->leftJoin('uploads','uploads.id','users.avatar_original')
      ->select(DB::raw("CONCAT('" . url('/') . "/public/', uploads.file_name) AS thumbnail_image"), 'users.name', 'users.email', 'users.phone')
      ->get();
        return response()->json([
            'result' => true,
            'data' => $users,
        ]);
    }
}
