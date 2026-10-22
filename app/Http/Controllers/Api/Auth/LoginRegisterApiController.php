<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\User;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginRegisterApiController extends Controller
{
    public function __invoke(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | API Disabled
        |--------------------------------------------------------------------------
        */

        if (settings()->pause_api_login) {
            return response()->json(
                [
                    'message' => __('backend.login_is_paused'),
                ],
                403,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'phone' => ['required', 'digits_between:9,10'],
            'otp' => ['required', 'digits:6'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Find User First
        |--------------------------------------------------------------------------
        */

        $user = User::query()->where('phone', $validated['phone'])->first();

        if ($user) {
            if ($user->account_status == UserAccountStatusEnum::Inactive->value) {
                return response()->json(
                    [
                        'message' => __('backend.account_inactive'),
                    ],
                    403,
                );
            }

            if ($user->account_status == UserAccountStatusEnum::Banned->value) {
                return response()->json(
                    [
                        'message' => __('backend.account_banned'),
                    ],
                    403,
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Verify OTP
        |--------------------------------------------------------------------------
        */

        $otp = OtpCode::query()
            ->where('phone', $validated['phone'])
            ->where('purpose', 'login_register')
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otp) {
            return response()->json(
                [
                    'message' => __('backend.invalid_otp'),
                ],
                422,
            );
        }

        if ($otp->expires_at->isPast()) {
            return response()->json(
                [
                    'message' => __('backend.otp_expired'),
                ],
                422,
            );
        }

        if ($otp->attempts >= 5) {
            return response()->json(
                [
                    'message' => __('backend.too_many_invalid_attempts'),
                ],
                429,
            );
        }

        if (!Hash::check($validated['otp'], $otp->code)) {
            $otp->increment('attempts');

            return response()->json(
                [
                    'message' => __('backend.invalid_otp'),
                ],
                422,
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove Used OTPs
        |--------------------------------------------------------------------------
        */

        OtpCode::query()->where('phone', $validated['phone'])->where('purpose', 'login_register')->delete();

        /*
        |--------------------------------------------------------------------------
        | Register If Needed
        |--------------------------------------------------------------------------
        */

        $user ??= User::create([
            'phone' => $validated['phone'],
            'account_status' => UserAccountStatusEnum::Active->value,
            'profile_completed' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Login
        |--------------------------------------------------------------------------
        */

        // تسجيل الخروج من جميع الأجهزة (اختياري)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'message' => $user->wasRecentlyCreated
                ? __('backend.account_register_successfuly')
                : __('backend.logged_in_successfuly'),

            'auth' => [
                'token' => $token,
                'type' => 'Bearer',
            ],

            'meta' => [
                'is_new_user' => $user->wasRecentlyCreated,
                'profile_completed' => (bool) $user->profile_completed,
            ],

            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'type' => $user->type,
            ],
        ]);
    }
}
