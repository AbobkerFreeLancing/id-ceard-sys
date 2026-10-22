<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Packages\Enum\Profile\UserTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginApiController extends Controller
{
    public function login(Request $request)
    {
        if (settings()->pause_api_login == true) {
            return response()->json(
                [
                    'message' => __('backend.login_is_paused'),
                ],
                401,
            );
        }

        $validated = $request->validate([
            'phone' => ['required', 'digits_between:9,10'],
            'password' => 'required|string',
        ]);

        $user = User::query()->where('phone', $validated['phone'])->first();
        $hashedPassword = $user?->password ?? Hash::make('fake-passw0rd-125AFD');

        if (!$user || !Hash::check($validated['password'], $hashedPassword)) {
            return response()->json(
                [
                    'message' => __('backend.invalid_login_details'),
                ],
                401,
            );
        }

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

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => __('backend.logged_in_successfuly'),
            'auth_token' => $token,
            'token_type' => 'Bearer',
            'id' => $user->type == UserTypeEnum::Rider->value ? $user->rider->id : $user->driver->id,
            'user_id' => $user->id,
            'type' => $user->type,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }
}
