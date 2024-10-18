<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\EmailManager;
use App\User;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $users = User::where('user_type', 'customer')->where('banned', 0)->select('email')->get();
        $subscribers = Subscriber::all();
        return view('backend.marketing.newsletters.index', compact('users', 'subscribers'));
    }

    public function send(Request $request)
    {
        if (env('MAIL_USERNAME') != null) {
            //sends newsletter to selected users
            if ($request->has('user_emails')) {
                foreach ($request->user_emails as $key => $email) {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content;

                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }
            }

            //sends newsletter to subscribers
            if ($request->has('subscriber_emails')) {
                foreach ($request->subscriber_emails as $key => $email) {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->content;

                    try {
                        Mail::to($email)->queue(new EmailManager($array));
                    } catch (\Exception $e) {
                        //dd($e);
                    }
                }
            }
        } else {
            flash(translate('Please configure SMTP first'))->error();
            return back();
        }

        flash(translate('Newsletter has been send'))->success();
        return redirect()->back();
    }

    public function testEmail(Request $request)
    {
        $array['view'] = 'emails.newsletter';
        $array['subject'] = "SMTP Test";
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = "This is a test email.";

        try {
            Mail::to($request->email)->queue(new EmailManager($array));
        } catch (\Exception $e) {
            dd($e);
        }

        flash(translate('An email has been sent.'))->success();
        return back();
    }

    public function message_to_customers_index(Request $request)
    {
        $users = User::where('user_type', 'customer')->where('banned', 0)->select('id','email')->get();
        return view('backend.marketing.newsletters.message_to_customers', compact('users'));
    }

    public function message_to_customers_send(Request $request)
    {
        if ($request->has('user_emails')) {
            foreach ($request->user_emails as $id) {
            // Generate Notification to user
            \App\Models\Notification::create([
                'user_id' => $id,
                'is_admin' => 3,
                'type' => 'message',
                'body' => translate('New message has been received from admin'),
                'content' => $request->content,
                'order_id' => 0,
            ]);
            try {
                // Send firebase notification
                $device_token = DB::table('device_tokens')->where('user_id', $id)->select('token')->get()->toArray();
                $array = array(
                    'device_token' => $device_token,
                    'title' => translate('New message has been received from admin')
                );
                send_firebase_notification($array);
            } catch (\Exception $e) {
                // dd($e);
            }
            }
        }

        flash(translate('Message has been send successfully'))->success();
        return redirect()->back();
    }

}
