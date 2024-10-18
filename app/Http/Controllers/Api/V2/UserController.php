<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use Lcobucci\JWT\Parser as JwtParser;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function getUserInfoByAccessToken(Request $request)
    {
        $token = $request->access_token;
        $false_response = [
            'result' => false,
            'id' => 0,
            'parent_id' => 0,
            'name' => "",
            'email' => "",
            'type' => "",
            'avatar_original' => "",
            'phone' => ""
        ];

        if ($token == "" || $token == null) {
            return response()->json($false_response);
        }

        try {
            $token_id = app(JwtParser::class)->parse($token)->claims()->get('jti');
        } catch (\Exception $e) {
            return response()->json($false_response);
        }

        $oauth_access_token_data =  DB::table('oauth_access_tokens')->where('id', '=', $token_id)->first();

        if ($oauth_access_token_data == null) {
            return response()->json($false_response);
        }

        $user = User::where('id', $oauth_access_token_data->user_id)->first();

        if ($user == null) {
            return response()->json($false_response);
        }

        return response()->json([
            'result' => true,
            'id' => $user->id,
            'parent_id' => ($user->user_type == 'seller')?$user->parent_id:0,
            'name' => $user->name,
            'email' => $user->email,
            'type' => $user->user_type,
            'avatar_original' => ($user->avatar_original != null) ? api_asset($user->avatar_original) : static_asset('assets/img/avatar-place.png'),
            'phone' => $user->phone                
        ]);
    }
}
