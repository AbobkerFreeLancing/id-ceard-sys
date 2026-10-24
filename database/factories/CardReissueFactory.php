<?php

namespace Database\Factories;

use App\Enums\ReissueReason;
use App\Enums\ReissueStatus;
use App\Models\Card;
use App\Models\CardReissue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CardReissue>
 */
class CardReissueFactory extends Factory
{
    protected $model = CardReissue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'old_card_id' => Card::factory(),
            'new_card_id' => null,
            'reason' => ReissueReason::Lost,
            'notes' => fake('ar_SA')->sentence(),
            'status' => ReissueStatus::Pending,
            'requested_by' => User::factory(),
            'approved_by' => null,
        ];
    }
}
