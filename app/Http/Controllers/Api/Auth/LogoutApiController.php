<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;

class LogoutApiController extends Controller
{
    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => __('backend.unauthenticated'),
            ], 401);
        }

        $user->tokens()->delete();

        return response()->json([
            'message' => __('backend.logged_out_successfuly'),
        ]);
    }
}
