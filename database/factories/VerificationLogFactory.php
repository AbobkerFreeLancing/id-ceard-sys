<?php

namespace Database\Factories;

use App\Enums\VerificationResult;
use App\Models\Card;
use App\Models\User;
use App\Models\VerificationLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VerificationLog>
 */
class VerificationLogFactory extends Factory
{
    protected $model = VerificationLog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'card_id' => Card::factory(),
            'scanned_uid' => (string) fake()->uuid(),
            'result' => VerificationResult::Valid,
            'scanned_by' => User::factory(),
            'device_id' => 'DEV-'.fake()->numerify('###'),
            'latitude' => 24.7136,
            'longitude' => 46.6753,
            'ip_address' => fake()->ipv4(),
            'scanned_at' => now(),
        ];
    }
}
