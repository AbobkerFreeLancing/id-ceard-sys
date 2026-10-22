<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\GeneralMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ResetPasswordApiController extends Controller
{
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            // 'email' => 'required|email',
            'phone' => 'required|string|regex:/^[0-9+\s-]{8,14}$/',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $resetRecord = DB::table('password_resets')->where('phone', $request->phone)->first();

        if (!$resetRecord || $request->token != $resetRecord->token) {
            return response()->json(['message' => __('backend.invalid_otp')], 400);
        }

        $tokenCreatedAt = Carbon::parse($resetRecord->created_at);
        if ($tokenCreatedAt->addMinutes(15)->isPast()) {
            DB::table('password_resets')->where('phone', $request->phone)->delete();
            return response()->json(['message' => __('backend.otp_expired')], 400);
        }

        $user = User::query()->where('phone', $request->phone)->first();
        DB::transaction(function () use ($user, $request) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            DB::table('password_resets')->where('phone', $request->phone)->delete();
        });
        // TODO : Sent to Phone or Email
        // Mail::to($user->email)->send(new GeneralMail(user: $user, subject: __('backend.password_reset_successfuly')));
        // Example: SendSmsService::send($request->phone, "Your reset code is: {$token}");

        return response()->json(['message' => __('backend.password_reset_successfuly')], 200);
    }
}
