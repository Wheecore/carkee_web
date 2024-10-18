<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.marketing.subscribers.index', compact('subscribers'));
    }

    public function store(Request $request)
    {
        $subscriber = Subscriber::where('email', $request->email)->first();
        if ($subscriber == null) {
            $subscriber = new Subscriber;
            $subscriber->email = $request->email;
            $subscriber->save();
            flash(translate('You have subscribed successfully'))->success();
        } else {
            flash(translate('You are  already a subscriber'))->success();
        }
        return back();
    }

    public function destroy($id)
    {
        Subscriber::destroy($id);
        flash(translate('Subscriber has been deleted successfully'))->success();
        return redirect()->route('subscribers.index');
    }
}
