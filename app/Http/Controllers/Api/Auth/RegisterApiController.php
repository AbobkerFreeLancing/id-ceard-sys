<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UserAccountCreatedEmail;
use App\Models\User;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Packages\Enum\Profile\UserTypeEnum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterApiController extends Controller
{
    public function register(Request $request)
    {
        if (settings()->pause_api_register == true) {
            return response()->json(
                [
                    'message' => __('backend.register_is_paused'),
                ],
                401,
            );
        }

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:60',
            'phone' => 'required|digits_between:9,10|unique:users',
            'password' => 'required|string|min:8',
            'email' => 'email|min:7|unique:users',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'type' => UserTypeEnum::Rider->value,
            'account_status' => UserAccountStatusEnum::Active->value,
            // 'account_status' => UserAccountStatusEnum::Inactive->value,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        // Send Email
        //Mail::to($user->email)->send(new UserAccountCreatedEmail($user));

        return response()->json(
            [
                'message' => __('backend.account_register_successfuly'),
                'auth_token' => $token,
                'token_type' => 'Bearer',
                'user_id' => $user->id,
                'type' => $user->type,
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
            ],
            201,
        );
    }
}
