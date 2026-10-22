<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Packages\IdCard\Enums\VerificationStatusEnum;
use Packages\IdCard\Models\VerificationLog;
use Packages\IdCard\Services\CardSecurityService;

/*
|--------------------------------------------------------------------------
| ID Card Package API Routes
|--------------------------------------------------------------------------
| Prefix: api/idcard/...
*/

Route::get('/verify/{token}', function (string $token, Request $request) {
    $card = CardSecurityService::resolveCardByToken($token);

    if (!$card) {
        VerificationLog::create([
            'card_id' => null,
            'scanned_token' => substr($token, 0, 100),
            'verification_status' => VerificationStatusEnum::InvalidToken,
            'scanner_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'device_type' => 'API-Consumer',
            'scanned_at' => now(),
        ]);

        return response()->json([
            'success' => false,
            'status' => VerificationStatusEnum::InvalidToken->value,
            'message' => __('idcard::idcard.verif_invalid_token'),
            'card' => null,
        ], 404);
    }

    $verifStatus = VerificationStatusEnum::Valid;
    if ($card->status->value === 'revoked' || $card->status->value === 'lost') {
        $verifStatus = VerificationStatusEnum::Revoked;
    } elseif ($card->status->value === 'suspended') {
        $verifStatus = VerificationStatusEnum::Suspended;
    } elseif ($card->isExpired()) {
        $verifStatus = VerificationStatusEnum::Expired;
    }

    VerificationLog::create([
        'card_id' => $card->id,
        'scanned_token' => substr($token, 0, 100),
        'verifier_user_id' => $request->user()?->id,
        'verification_status' => $verifStatus,
        'scanner_ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'device_type' => 'API-Consumer',
        'scanned_at' => now(),
    ]);

    return response()->json([
        'success' => $verifStatus === VerificationStatusEnum::Valid,
        'status' => $verifStatus->value,
        'message' => $verifStatus->label(),
        'card' => [
            'card_uid' => $card->card_uid,
            'card_number' => $card->card_number,
            'full_name' => $card->cardholder->full_name_ar,
            'identifier_code' => $card->cardholder->identifier_code,
            'department' => $card->cardholder->department?->name,
            'photo_url' => $card->cardholder->photo_url,
            'issue_date' => $card->issue_date->format('Y-m-d'),
            'expiry_date' => $card->expiry_date->format('Y-m-d'),
        ],
    ]);
});
