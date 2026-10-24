<?php

namespace Database\Factories;

use App\Enums\CardStatus;
use App\Models\Card;
use App\Models\Cardholder;
use App\Models\CardTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Card>
 */
class CardFactory extends Factory
{
    protected $model = Card::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cardUid = (string) Str::uuid();

        return [
            'card_uid' => $cardUid,
            'cardholder_id' => Cardholder::factory(),
            'template_id' => CardTemplate::factory(),
            'qr_payload' => base64_encode(json_encode([
                'uid' => $cardUid,
                'ts' => now()->timestamp,
                'sig' => hash_hmac('sha256', $cardUid, 'huwia-secret-key'),
            ])),
            'status' => CardStatus::Active,
            'issued_at' => now(),
            'expires_at' => now()->addYear(),
            'print_count' => 1,
        ];
    }
}
