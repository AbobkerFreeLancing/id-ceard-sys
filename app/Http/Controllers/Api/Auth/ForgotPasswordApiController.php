<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetOtpMail;
use App\Models\User;
use Packages\Helpers\BedayaHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordApiController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|regex:/^[0-9+\s-]{8,14}$/',
            // 'email' => 'required|email|regex:/^[^@\s]+@[^@\s]+\.[^@\s]+$/',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // $user = User::query()->where('email', $request->email)->first();
        $user = User::query()->where('phone', $request->phone)->first();

        if ($user) {
            $token = BedayaHelper::otp();

            DB::table('password_resets')->updateOrInsert(
                ['phone' => $request->phone],
                [
                    'phone' => $request->phone,
                    'token' => $token,
                    'created_at' => now(),
                ],
            );

            // TODO: Send OTP via your SMS provider
            // Mail::to($request->email)->send(new PasswordResetOtpMail($user, $token));
            // Example: SendSmsService::send($request->phone, "Your reset code is: {$token}");
        }

        // return response()->json(['message' => __('backend.password_reset_sent_email_gen_msg')]);
        return response()->json(['message' => __('backend.password_reset_sent_phone_gen_msg')]);
    }
}
