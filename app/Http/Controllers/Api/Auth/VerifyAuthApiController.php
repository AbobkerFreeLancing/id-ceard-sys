<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Packages\Enum\Profile\UserAccountStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VerifyAuthApiController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->account_status == UserAccountStatusEnum::Inactive->value) {
            $request->user()->currentAccessToken()?->delete();
            return response()->json(
                [
                    'message' => __('backend.account_inactive'),
                ],
                403,
            );
        }

        if ($user->account_status == UserAccountStatusEnum::Banned->value) {
            $request->user()->currentAccessToken()?->delete();
            return response()->json(
                [
                    'message' => __('backend.account_banned'),
                ],
                403,
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Token is valid.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ],
            200,
        );
    }
}
