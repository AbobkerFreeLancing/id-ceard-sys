<?php

namespace Database\Factories;

use App\Enums\BatchStatus;
use App\Models\CardBatch;
use App\Models\CardTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CardBatch>
 */
class CardBatchFactory extends Factory
{
    protected $model = CardBatch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_no' => 'B-'.date('Y').'-'.fake()->unique()->numerify('####'),
            'template_id' => CardTemplate::factory(),
            'status' => BatchStatus::Ready,
            'cards_per_sheet' => 8,
            'total_cards' => 0,
            'created_by' => User::factory(),
            'printed_at' => null,
        ];
    }
}
