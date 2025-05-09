<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        } else {
            if (Addon::where('unique_identifier', 'otp_system')->first() != null && Addon::where('unique_identifier', 'otp_system')->first()->activated) {
                $user = User::create([
                    'name' => $data['name'],
                    'phone' => '+' . $data['country_code'] . $data['phone'],
                    'password' => Hash::make($data['password']),
                    'verification_code' => rand(100000, 999999)
                ]);

                $customer = new Customer;
                $customer->user_id = $user->id;
                $customer->save();
            }
        }

        if (Cookie::has('referral_code')) {
            $referral_code = Cookie::get('referral_code');
            $referred_by_user = User::where('referral_code', $referral_code)->first();
            if ($referred_by_user != null) {
                $user->referred_by = $referred_by_user->id;
                $user->save();
            }
        }

        return $user;
    }

    public function register(Request $request)
    {

        //dd(date('d-m-Y'));


        $start_date = date('d-m-Y', strtotime(Carbon::now()));

        $end_date_format = Carbon::now()->addDays(30);
        $end_date = date('d-m-Y', strtotime($end_date_format));

        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email or Phone already exists.'));
                return back();
            }
        } elseif (User::where('phone', '+' . $request->country_code . $request->phone)->first() != null) {
            flash(translate('Phone already exists.'));
            return back();
        }

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        $coupon = new Coupon();

        if (Auth::user()->referred_by) {
            $coupon->user_id = Auth::id();
            $coupon->type             = 'cart_base';
            $coupon->code             = Str::random(11);
            $coupon->discount         = 10;
            $coupon->discount_type    = 'amount';
            $coupon->start_date       = strtotime($start_date);
            $coupon->end_date         = strtotime($end_date);
            $coupon->details = '{"min_buy":"3","max_discount":"5"}';
            $coupon->limit         = 1;

            $coupon->save();
        }

        //        if($user->email != null){
        //            if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
        //                $user->email_verified_at = date('Y-m-d H:m:s');
        //                $user->save();
        //                flash(translate('Registration successfull.'))->success();
        //            }
        //            else {
        //                event(new Registered($user));
        //                flash(translate('Registration successfull. Please verify your email.'))->success();
        //            }
        //        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        //        if ($user->email == null) {
        //            return redirect()->route('verification');
        //        }
        //        else {
        return redirect()->route('home');
        //        }
    }
}
