<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Packages\Helpers\BedayaHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OtpApiController extends Controller
{
    public function send(Request $request)
    {
        if (settings()->pause_api_login) {
            return response()->json(
                [
                    'message' => __('backend.login_is_paused'),
                ],
                403,
            );
        }

        $validated = $request->validate([
            'phone' => ['required', 'digits_between:9,10'],
        ]);

        // Remove Old OTPs
        OtpCode::query()->where('phone', $validated['phone'])->delete();

        // Create new OTP
        $code = BedayaHelper::otp();

        // Save
        OtpCode::create([
            'phone' => $validated['phone'],
            'purpose' => 'login_register',
            'code' => Hash::make($code),
            'expires_at' => now()->addMinutes(5),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
        ]);

        /*
         | Send SMS
         | SmsService::send($validated['phone'], "رمز التحقق هو {$code}");
         |
         */

        return response()->json([
            'message' => __('backend.otp_sent_successfully'),
            // احذف هذا السطر في بيئة الإنتاج
            'otp' => app()->isLocal() ? $code : null,
        ]);
    }

    public function verify(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'digits_between:9,10'],
            'otp' => ['required', 'digits:6'], // Adjust digits based on your BedayaHelper::otp()
        ]);

        // 1. Get the latest valid OTP for this phone and purpose
        $otp = OtpCode::query()->where('phone', $validated['phone'])->latest()->first();

        // 2. Check if OTP exists, is not expired, and matches the hash
        if (!$otp || $otp->expires_at->isPast() || !Hash::check($validated['otp'], $otp->code)) {
            return response()->json(
                [
                    'message' => __('backend.invalid_or_expired_otp'),
                ],
                401,
            );
        }

        // 3. OTP is correct! Delete it so it can't be reused
        $otp->delete();

        // 4. Find or Create the User
        $user = User::firstOrCreate(
            ['phone' => $validated['phone']],
            [
                'account_status' => UserAccountStatusEnum::Active->value,
            ],
        );

        // 5. Check if user is banned/inactive (if they already existed)
        if ($user->account_status == UserAccountStatusEnum::Banned->value) {
            return response()->json(['message' => __('backend.account_banned')], 403);
        }

        if ($user->account_status == UserAccountStatusEnum::Inactive->value) {
            return response()->json(['message' => __('backend.account_inactive')], 403);
        }

        // 6. Generate Sanctum Token
        $user->tokens()->delete(); // Optional: logout other devices
        $token = $user->createToken('auth_token')->plainTextToken;

        // 7. Return response
        return response()->json([
            'message' => __('backend.logged_in_successfuly'),
            'auth_token' => $token,
            'token_type' => 'Bearer',
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }
}
