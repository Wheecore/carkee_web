<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Notifications\AppEmailVerificationNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        if (User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first() != null) {
            return response()->json([
                'result' => false,
                'message' => 'User already exists.',
                'user_id' => 0
            ], 201);
        }
        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'verification_code' => rand(100000, 999999),
            'timezone' => get_local_time()
        ];
        if ($request->register_by == 'email') {
            $data['email'] = $request->email_or_phone;
        } else {
            $data['phone'] = $request->email_or_phone;
        }
        $user = new User($data);

        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        }
        // elseif ($request->register_by == 'email') {
        //     $user->notify(new AppEmailVerificationNotification());
        // } else {
        //     $otpController = new OTPVerificationController();
        //     $otpController->send_code($user);
        // }

        $user->save();
        $this->updateDeviceToken($user, $request->device_token);

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();
        return response()->json([
            'result' => true,
            'message' => 'Registration Successful. Now please login to continue.',
            'user_id' => $user->id
        ], 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->verification_code = rand(100000, 999999);

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Verification code is sent again',
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();
            return response()->json([
                'result' => true,
                'message' => 'Your account is now verified.Please login',
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Code does not match, you can request for resending the code',
            ], 200);
        }
    }

    public function login(Request $request)
    {
        /*$request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);*/

        if ($request->has('user_type') && $request->user_type == 'delivery_boy') {
            $user = User::whereIn('user_type', ['delivery_boy'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        } else {
            $user = User::whereIn('user_type', ['customer', 'seller','merchant', 'technician'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        }

        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {

                if ($user->banned == 1) {
                    return response()->json(['result' => false, 'message' => 'Your account is not active', 'user' => null], 401);
                }
                // if ($user->email_verified_at == null) {
                //     return response()->json(['message' => 'Please verify your account', 'user' => null], 401);
                // }
                // if (!$user->timezone) {
                    $user->update(['timezone' => get_local_time()]);
                // }
                $this->updateDeviceToken($user, $request->device_token);
                $tokenResult = $user->createToken('Personal Access Token');
                return $this->loginSuccess($tokenResult, $user);

            } else {
                return response()->json(['result' => false, 'message' => 'Password is invalid', 'user' => null], 401);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'User not found', 'user' => null], 401);
        }

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

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $this->updateDeviceToken($request->user(), $request->device_token, 'logout');
        $request->user()->token()->revoke();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function socialLogin(Request $request)
    {
        if (User::where('email', $request->email)->first() != null) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now(),
                'timezone' => get_local_time()
            ]);
            $user->save();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        $tokenResult = $user->createToken('Personal Access Token');
        $this->updateDeviceToken($user, $request->device_token);
        return $this->loginSuccess($tokenResult, $user);
    }

    protected function loginSuccess($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged in',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'parent_id' => ($user->user_type == 'seller')?$user->parent_id:0,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_original' => ($user->avatar_original != null) ? api_asset($user->avatar_original) : static_asset('assets/img/avatar-place.png'),
                'phone' => $user->phone
            ]
        ]);
    }

    public function delete_user_account($user_id){        
        DB::table('addresses')->where('user_id', $user_id)->delete();
        DB::table('browse_histories')->where('user_id', $user_id)->delete();
        DB::table('carts')->where('user_id', $user_id)->delete();
        DB::table('cart_package_products')->where('user_id', $user_id)->delete();
        DB::table('car_wash_usages')->where('user_id', $user_id)->delete();
        DB::table('car_wash_payments')->where('user_id', $user_id)->delete();
        DB::table('car_wash_memberships')->where('user_id', $user_id)->delete();
        DB::table('car_lists')->where('user_id', $user_id)->delete();
        DB::table('customers')->where('user_id', $user_id)->delete();
        DB::table('notifications')->where('user_id', $user_id)->delete();
        DB::table('orders')->where('user_id', $user_id)->delete();
        DB::table('reviews')->where('user_id', $user_id)->delete();
        DB::table('payments')->where('user_id', $user_id)->delete();
        DB::table('rating_orders')->where('user_id', $user_id)->delete();
        DB::table('reviews')->where('user_id', $user_id)->delete();
        DB::table('tickets')->where('user_id', $user_id)->delete();
        DB::table('ticket_replies')->where('user_id', $user_id)->delete();
        DB::table('users')->where('id', $user_id)->delete();
        
        return response()->json([
            'result' => true,
            'message' => 'Account deleted successfully'
        ]);
    }

}
