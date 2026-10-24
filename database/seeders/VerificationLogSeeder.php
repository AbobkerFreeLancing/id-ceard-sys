<?php

namespace Database\Seeders;

use App\Enums\CardStatus;
use App\Enums\ReissueReason;
use App\Enums\ReissueStatus;
use App\Enums\VerificationResult;
use App\Models\Card;
use App\Models\CardReissue;
use App\Models\User;
use App\Models\VerificationLog;
use Illuminate\Database\Seeder;

class VerificationLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officer = User::where('email', 'security@huwia.test')->first();
        $activeCard = Card::where('status', CardStatus::Active)->first();
        $expiredCard = Card::where('status', CardStatus::Expired)->first();

        if ($activeCard && $officer) {
            VerificationLog::create([
                'card_id' => $activeCard->id,
                'scanned_uid' => $activeCard->card_uid,
                'result' => VerificationResult::Valid,
                'scanned_by' => $officer->id,
                'device_id' => 'GATE-SCANNER-A1',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'ip_address' => '192.168.1.105',
                'scanned_at' => now()->subMinutes(15),
            ]);
        }

        if ($expiredCard && $officer) {
            VerificationLog::create([
                'card_id' => $expiredCard->id,
                'scanned_uid' => $expiredCard->card_uid,
                'result' => VerificationResult::Expired,
                'scanned_by' => $officer->id,
                'device_id' => 'GATE-SCANNER-A1',
                'latitude' => 24.7136,
                'longitude' => 46.6753,
                'ip_address' => '192.168.1.105',
                'scanned_at' => now()->subHours(2),
            ]);

            // إضافة طلب إعادة إصدار تجريبي للبطاقة المنتهية/التالفة
            CardReissue::firstOrCreate(
                ['old_card_id' => $expiredCard->id],
                [
                    'new_card_id' => null,
                    'reason' => ReissueReason::Damaged,
                    'notes' => 'الشريحة والباركود تالفان نتيجة الاستخدام المستمر',
                    'status' => ReissueStatus::Pending,
                    'requested_by' => $officer->id,
                    'approved_by' => null,
                ]
            );
        }

        if ($officer) {
            VerificationLog::create([
                'card_id' => null,
                'scanned_uid' => 'FAKE-OR-EXTERNAL-UID-999',
                'result' => VerificationResult::Unknown,
                'scanned_by' => $officer->id,
                'device_id' => 'SECURITY-MOBILE-APP',
                'latitude' => 24.7140,
                'longitude' => 46.6760,
                'ip_address' => '10.0.0.42',
                'scanned_at' => now()->subDays(1),
            ]);
        }
    }
}
