<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function edit()
    {
        $video = DB::table('videos')->where('id', 1)->first();
        return view('backend.video.edit', compact('video'));
    }

    public function update($id, Request $request)
    {
        if ($request->file) {
            $file = $request->file;
            $filename = $file->getClientOriginalName();
            $path = public_path() . '/uploads/';
            $file->move($path, $filename);
        }
        else{
            $filename =DB::table('videos')->where('id', 1)->first()->video;
        }
        DB::table('videos')->where('id', 1)->update(['video' => $filename]);
        flash(translate('Updated successfully'))->success();
        return back();
    }
}
