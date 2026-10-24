<?php

namespace Database\Seeders;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Cardholder;
use App\Models\CardTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $holder1 = Cardholder::where('national_id', '1098765432')->first();
        $holder2 = Cardholder::where('national_id', '1087654321')->first();
        $holder3 = Cardholder::where('national_id', '1023456789')->first();
        $holder4 = Cardholder::where('national_id', '1034567890')->first();

        $studentTemplate = CardTemplate::where('name', 'like', '%طالب%')->first();
        $doctorTemplate = CardTemplate::where('name', 'like', '%طبي%')->first();

        if ($holder1 && $studentTemplate) {
            $uid1 = (string) Str::uuid();
            Card::firstOrCreate(
                ['cardholder_id' => $holder1->id],
                [
                    'card_uid' => $uid1,
                    'template_id' => $studentTemplate->id,
                    'qr_payload' => base64_encode(json_encode([
                        'uid' => $uid1,
                        'ts' => now()->timestamp,
                        'sig' => hash_hmac('sha256', $uid1, 'huwia-secret-key'),
                    ])),
                    'status' => CardStatus::Active,
                    'issued_at' => now()->subMonths(2),
                    'expires_at' => now()->addYears(3),
                    'print_count' => 1,
                ]
            );
        }

        if ($holder2 && $studentTemplate) {
            $uid2 = (string) Str::uuid();
            Card::firstOrCreate(
                ['cardholder_id' => $holder2->id],
                [
                    'card_uid' => $uid2,
                    'template_id' => $studentTemplate->id,
                    'qr_payload' => base64_encode(json_encode([
                        'uid' => $uid2,
                        'ts' => now()->timestamp,
                        'sig' => hash_hmac('sha256', $uid2, 'huwia-secret-key'),
                    ])),
                    'status' => CardStatus::Active,
                    'issued_at' => now()->subMonths(1),
                    'expires_at' => now()->addYears(3),
                    'print_count' => 1,
                ]
            );
        }

        if ($holder3 && $doctorTemplate) {
            $uid3 = (string) Str::uuid();
            Card::firstOrCreate(
                ['cardholder_id' => $holder3->id],
                [
                    'card_uid' => $uid3,
                    'template_id' => $doctorTemplate->id,
                    'qr_payload' => base64_encode(json_encode([
                        'uid' => $uid3,
                        'ts' => now()->timestamp,
                        'sig' => hash_hmac('sha256', $uid3, 'huwia-secret-key'),
                    ])),
                    'status' => CardStatus::Active,
                    'issued_at' => now()->subMonths(6),
                    'expires_at' => now()->addMonths(18),
                    'print_count' => 1,
                ]
            );
        }

        if ($holder4 && $doctorTemplate) {
            $uidExpired = (string) Str::uuid();
            Card::firstOrCreate(
                ['cardholder_id' => $holder4->id],
                [
                    'card_uid' => $uidExpired,
                    'template_id' => $doctorTemplate->id,
                    'qr_payload' => base64_encode(json_encode([
                        'uid' => $uidExpired,
                        'ts' => now()->subYears(2)->timestamp,
                        'sig' => hash_hmac('sha256', $uidExpired, 'huwia-secret-key'),
                    ])),
                    'status' => CardStatus::Expired,
                    'issued_at' => now()->subYears(2),
                    'expires_at' => now()->subMonth(),
                    'print_count' => 1,
                ]
            );
        }
    }
}
