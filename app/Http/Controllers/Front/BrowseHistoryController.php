<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BrowseHistory;
use Illuminate\Support\Facades\Auth;

class BrowseHistoryController extends Controller
{
    public function index()
    {
        $histories = BrowseHistory::where('user_id', Auth::id())->get();
        return view('frontend.user.browse_history', compact('histories'));
    }

    public function delete($id)
    {
        $history = BrowseHistory::where('user_id', Auth::id())->where('product_id', $id)->first();
        $history->delete();
        flash(translate('Item has been deleted successfully'))->success();
        return back();
    }
}
