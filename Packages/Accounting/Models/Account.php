<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Packages\Accounting\Enum\AccountLevelTypeEnum;
use Packages\Traits\BelongsToBranchTrait;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Account extends Model
{
    use HasFactory;
    use HasEnabledScope;
    // use BelongsToBranchTrait;

    protected $guarded = [];

    protected $appends = ['name_balance'];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_editable' => 'boolean',
        ];
    }

    public function scopeGroup(Builder $query): void
    {
        $query->where('level_type', AccountLevelTypeEnum::Group->value);
    }

    public function scopeSub(Builder $query): void
    {
        $query->where('level_type', AccountLevelTypeEnum::Sub->value);
    }

    public function scopeSafe(Builder $query): void
    {
        $query->where('slug', 'safe_account');
    }

    public static function tree()
    {
        $allAccounts = Account::get();

        $rootAccounts = $allAccounts->whereNull('parent_id');

        self::formatTree($rootAccounts, $allAccounts);

        return $rootAccounts;
    }

    private static function formatTree($accounts, $allAccounts)
    {
        foreach ($accounts as $account) {
            $account->children = $allAccounts->where('parent_id', $account->id)->values();

            if ($account->children->isNotEmpty()) {
                self::formatTree($account->children, $allAccounts);
            }
        }
    }

    public function isChild(): bool
    {
        return $this->parent_id != null;
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Account::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // Recursive parents
    public function parents()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parent');
    }

    public function getTypeLabelAttribute()
    {
        if ($this->type == 'debit') {
            return __('backend.debit');
        } elseif ($this->type == 'credit') {
            return __('backend.credit');
        }
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getDebitSumAttribute()
    {
        $debit = $this->transactions()->where('type', 'debit')->pluck('amount')->sum();

        return number_format($debit, 2);
    }

    public function getCreditSumAttribute()
    {
        $credit = $this->transactions()->where('type', 'credit')->pluck('amount')->sum();

        return number_format($credit, 2);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getNameBalanceAttribute()
    {
        return $this->name . ' - ' . number_format($this->balance, 2);
    }

    public function getNameBalanceCurrencyAttribute()
    {
        return $this->name . ' - ' . number_format($this->balance, 2) . ' ' . $this->currency?->symbol;
    }

    public function getNameCurrencyAttribute()
    {
        return $this->name . ' - ' . $this->currency?->symbol;
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
