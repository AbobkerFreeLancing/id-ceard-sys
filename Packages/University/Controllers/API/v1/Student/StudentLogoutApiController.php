<?php

namespace Packages\University\Controllers\API\v1\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentLogoutApiController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(
                [
                    'message' => __('backend.unauthenticated'),
                ],
                401,
            );
        }

        $user->tokens()->delete();

        return response()->json([
            'message' => __('backend.logged_out_successfuly'),
        ]);
    }
}
