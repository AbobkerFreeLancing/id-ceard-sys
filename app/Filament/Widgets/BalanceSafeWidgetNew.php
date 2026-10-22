<?php

namespace App\Filament\Widgets;

use Packages\Accounting\Models\Account;
use Filament\Widgets\Widget;

class BalanceSafeWidgetNew extends Widget
{
    public $data = [];

    protected string $view = 'filament.widgets.balance-safe-widget-new';

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return false;
        return auth()->user()->can('safes_management') &&
            config('bedaya.accounting_enabled') &&
            Account::safe()->enabled()->exists();
    }

    public function mount()
    {
        $this->data = Account::safe()->enabled()->latest()->limit(4)->get();
    }

    public function getColumnSpan(): int|string|array
    {
        return [
            'default' => 12,
            'xl' => 12,
        ];
    }
}
