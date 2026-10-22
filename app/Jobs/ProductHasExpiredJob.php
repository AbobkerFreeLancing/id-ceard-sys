<?php

namespace App\Jobs;

use App\Models\User;
use Filament\Notifications\Notification as Notify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Packages\Warehouse\Models\Product;
use Packages\Warehouse\Models\ProductWarehouse;

class ProductHasExpiredJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public ProductWarehouse $pwh)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notify::make()
        ->title('Expire Alert:' . " " . Product::find($this->pwh->product_id)->name)
        ->body(trans('backend.expire_date') . ": " . $this->pwh->expire_date)
        ->icon('heroicon-o-scissors')
        ->sendToDatabase(User::all());
    }
}
