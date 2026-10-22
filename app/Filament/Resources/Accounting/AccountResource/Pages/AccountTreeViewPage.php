<?php

namespace App\Filament\Resources\Accounting\AccountResource\Pages;

use App\Filament\Resources\Accounting\AccountResource;
use Packages\Accounting\Models\Account;
use Filament\Resources\Pages\Page;

class AccountTreeViewPage extends Page
{
    public function mount()
    {
        $this->account_list = Account::tree();
    }

    protected static string $resource = AccountResource::class;
    protected string $view = 'filament.pages.account-tree-view-page';

    public function getHeading(): string
    {
        return __('backend.accounts_tree_view');
    }

    public static function getNavigationLabel(): string
    {
        return __('backend.accounts_tree_view');
    }
}
