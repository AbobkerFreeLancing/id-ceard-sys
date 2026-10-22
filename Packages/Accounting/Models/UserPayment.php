<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPayment extends Model
{
    use HasEnabledScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (self $py) {
            $py->ref_number = 'PY-' . $py->id;
            $py->save();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account_to(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }

    public function account_from(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(UserPaymentItem::class);
    }
}
