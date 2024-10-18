<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function forgetRequest(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
            'result' => false,
            'message' => 'User is not found'
        ], 404);
        }

        if ($user) {
            $user->verification_code = rand(100000, 999999);
            $user->save();
            $data = array(
             'subject' => 'Forgot password verification code',
             'content' => 'Your code is:'.$user->verification_code
            );
            // Send email to user email address
            try{
            Mail::send(['html'=>'emails.app_verification'], $data, function($message) use($request) {
                $message->to($request->email, env('APP_NAME'))
                ->subject('Forgot password verification code - '.env('APP_NAME'));
                $message->from(env('MAIL_FROM_ADDRESS'),env('APP_NAME'));
            });
            }
            catch(\Exception $e){
                // echo $e;
            }
        }

        return response()->json([
            'result' => true,
            'message' => 'Verification code has been ent to your email address.'
        ], 200);
    }

    public function checkCode(Request $request)
    {
        $user = User::where('verification_code', $request->verification_code)->first();
        if ($user) {
            return response()->json([
                'result' => true,
                'user_id' => $user->id,
                'message' => 'Done'
            ], 200);
        }
        return response()->json([
            'result' => false,
            'user_id' => 0,
            'message' => 'The given code is invalid',
        ], 200);
    }

    public function confirmReset(Request $request)
    {
        $user = User::find($request->user_id);
        $user->verification_code = null;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'result' => true,
            'message' => 'Your password has been reset successfully. Please login with your new password',
        ], 200);
    }
}
