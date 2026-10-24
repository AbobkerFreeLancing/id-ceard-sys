<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\CardBatch;
use App\Models\CardBatchItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CardBatchItem>
 */
class CardBatchItemFactory extends Factory
{
    protected $model = CardBatchItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'batch_id' => CardBatch::factory(),
            'card_id' => Card::factory(),
            'position' => 1,
        ];
    }
}
