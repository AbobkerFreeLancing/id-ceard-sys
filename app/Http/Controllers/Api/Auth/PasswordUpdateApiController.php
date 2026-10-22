<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PasswordUpdateApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();


        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => __('backend.current_password_incorrect')
            ], 422);
        }


        DB::transaction(function () use ($user, $validated) {

            $user->update([
                'password' => Hash::make($validated['password']),
                'password_changed_at' => now(),
            ]);

            $user->tokens()->delete();
        });


        // Create token for current device
        $token = $user->createToken($request->header('device-name', 'mobile'))->plainTextToken;

        return response()->json([
            'message' => __('backend.password_reset_successfuly'),
            'token' => $token,
        ]);
    }
}
