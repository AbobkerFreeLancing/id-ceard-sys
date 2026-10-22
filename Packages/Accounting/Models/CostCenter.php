<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CostCenter extends Model
{
    use HasFactory;
    use HasEnabledScope;

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
        $query->where('level_type', 'group');
    }

    public function scopeSub(Builder $query): void
    {
        $query->where('level_type', 'sub');
    }

    public function isGroup(): bool
    {
        return $this->level_type === 'group';
    }

    public function isSub(): bool
    {
        return $this->level_type === 'sub';
    }

    public static function tree()
    {
        $allAccounts = CostCenter::get();

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

    // One level child
    public function child()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    // Recursive children
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->with('children');
    }

    // One level parent
    public function parent()
    {
        return $this->belongsTo(self::class);
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
