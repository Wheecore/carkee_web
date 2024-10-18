<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformativePagesController extends Controller
{
    public function index()
    {
       return view('frontend.informative-pages.index');
    }

    public function contact()
    {
        return view('frontend.informative-pages.contact');
    }

    public function about()
    {
        return view('frontend.informative-pages.about');
    }

    public function faq()
    {
        return view('frontend.informative-pages.faq');
    }

    public function team()
    {
        return view('frontend.informative-pages.team');
    }

    public function privacy_policy()
    {
        return view('frontend.informative-pages.privacy_policy');
    }

    public function register_customer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $referred_by_user = DB::table('users')->select('id')->where('referral_code', request()->referral_code)->first();
        if ($referred_by_user) {
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $user = \App\User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => \Hash::make($request->password),
                    'referred_by' => $referred_by_user->id,
                ]);
    
                $customer = new \App\Models\Customer;
                $customer->user_id = $user->id;
                $customer->save();

                return redirect(route('register'))->with('success', translate('Your account has been registered successfully please download the application to use Carkee services'));
            } else {
                return back()->with('warning', translate('Your email address is invalid'));
            }
        } else {
            return back()->with('warning', translate('There is no referral user found in our records try again with correct referral url'));
        }
    }

    public function contact_submit(Request $request)
    {
        $to = 'enquiry@carkee.my';
        $subject = 'Marriage Proposal';
        $message = '<div><p>' . $request->subject . '</p></div><div><p>Email: ' . $request->email . '</p><p>Message: ' . $request->message . '</p></div>'; 
        $headers = array(
            'From' => 'enquiry@carkee.my',
            'Reply-To' => 'enquiry@carkee.my',
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html;charset=UTF-8'
        );

        try {
            mail($to, $subject, $message, $headers);
        } catch (\Exception $e) {
            dd($e);
        }
        return 1;
    }
}
