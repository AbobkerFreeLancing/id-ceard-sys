<?php

namespace Database\Seeders;

use App\Enums\BatchStatus;
use App\Models\Card;
use App\Models\CardBatch;
use App\Models\CardBatchItem;
use App\Models\CardTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;

class CardBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@huwia.test')->first();
        $studentTemplate = CardTemplate::where('name', 'like', '%طالب%')->first();
        $cards = Card::where('template_id', $studentTemplate?->id)->take(2)->get();

        if ($studentTemplate && $admin) {
            $batch = CardBatch::firstOrCreate(
                ['batch_no' => 'B-'.date('Y').'-0001'],
                [
                    'template_id' => $studentTemplate->id,
                    'status' => BatchStatus::Printed,
                    'cards_per_sheet' => 8,
                    'total_cards' => $cards->count(),
                    'created_by' => $admin->id,
                    'printed_at' => now()->subDays(10),
                ]
            );

            foreach ($cards as $index => $card) {
                CardBatchItem::firstOrCreate(
                    [
                        'batch_id' => $batch->id,
                        'card_id' => $card->id,
                    ],
                    [
                        'position' => $index + 1,
                    ]
                );
            }
        }
    }
}
