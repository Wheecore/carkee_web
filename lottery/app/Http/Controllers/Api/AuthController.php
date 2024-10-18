<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                $this->updateDeviceToken($user, $request->device_token);
                $tokenResult = $user->createToken('Personal Access Token');
                return $this->login_success($tokenResult, $user);
            } else {
                return response()->json([
                    'result' => false,
                    'data' => [
                        'user' => null
                    ],
                    'message' => 'Your password is invalid',
                    'status' => 201
                ], 201);
            }
        } else {
            return response()->json([
                'result' => false,
                'data' => [
                    'user' => null
                ],
                'message' => 'User account not found',
                'status' => 201
            ], 201);
        }
    }

    public function social_login(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = new User([
                'user_type' => 'user',
                'name' => $request->name,
                'email' => $request->email,
                'provider' => $request->provider,
                'provider_id' => $request->provider_id,
                'email_verified_at' => Carbon::now(),
            ]);
            $user->save();
        }

        $this->updateDeviceToken($user, $request->device_token);
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->login_success($tokenResult, $user);
    }

    protected function login_success($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'result' => true,
            'data' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                'user' => [
                    'id' => $user->id,
                    'user_type' => $user->user_type,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'provider' => $user->provider,
                    'profile_img' => uploaded_asset($user->attachment_id),
                    'provider_id' => $user->provider_id,
                    'delivery_address' => $user->delivery_address
                ]
            ],
            'message' => 'Login successful',
            'status' => 200
        ], 200);
    }

    public function logout(Request $request)
    {
        $this->updateDeviceToken($request->user(), $request->device_token, 'logout');
        $request->user()->token()->delete();
        return response()->json([
            'result' => true,
            'message' => 'Logout successfully'
        ], 200);
    }

    public function delete_user_account(Request $request){    
        DB::table('users')->where('id', $request->user_id)->delete();
        return response()->json([
            'result' => true,
            'message' => 'Account deleted successfully',
        ], 200);  
    }

    public function register(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            return response()->json([
                'result' => false,
                'data' => [
                    'user' => null
                ],
                'message' => 'User already exists with this email',
                'status' => 201
            ], 201);
        }
        $data = [
                'user_type' => 'user',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'delivery_address' => $request->delivery_address
            ];
            $user = new User($data);
            $user->save();
            $this->updateDeviceToken($user, $request->device_token);
            $tokenResult = $user->createToken('Personal Access Token');
            return $this->login_success($tokenResult, $user);
    }

    public function updateDeviceToken($user, $device_token, $action = 'login')
    {
        if ($action == 'logout') {
            DB::table('device_tokens')->where('user_id', $user->id)->where('token', $device_token)->delete();
        } else {
            if ($device_token) {
                $check = DB::table('device_tokens')->select('id')->where('user_id', $user->id)->where('token', $device_token)->first();
                if (!$check) {
                    DB::table('device_tokens')->insert([
                        'user_id' => $user->id,
                        'token' => $device_token,
                    ]);
                }
            }
        }
    }

}
