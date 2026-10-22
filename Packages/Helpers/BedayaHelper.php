<?php

namespace Packages\Helpers;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BedayaHelper
{
    public static function transactionReference(string $prefix = 'TX'): string
    {
        $timePart = date('YmdHis') . substr(explode('.', microtime(true))[1] ?? '00', 0, 4);
        $randomPart = bin2hex(random_bytes(4)); // Generates 8 random alphanumeric characters
        // return strtoupper("{$prefix}-{$timePart}-{$randomPart}");
        return strtoupper("{$prefix}-{$timePart}");
    }

    public static function voucherToken(): string
    {
        return strtoupper(random_int(1000, 9999) . Str::random(4) . random_int(1000, 9999));
    }

    public static function slugRandom(): string
    {
        return (string) date('is') . (string) strtoupper(bin2hex(random_bytes(6)));
    }

    public static function uniqueToken(): string
    {
        return Str::uuid()->toString() . time();
    }

    public static function APIKey(): string
    {
        return strtoupper('.API.' . Str::random(8) . time() . date('.M.') . date('y.') . Str::random(8));
    }

    public static function otp(): string
    {
        return (string) random_int(100000, 999999);
    }

    public static function walletAccountNum(): string
    {
        return (string) random_int(10000000, 99999999);
    }

    public static function taxiRideRef(): string
    {
        return 'RD-' . (string) date('is') . (string) strtoupper(bin2hex(random_bytes(6)));
    }
}
