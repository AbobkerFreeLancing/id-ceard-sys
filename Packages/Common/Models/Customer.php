<?php

namespace Packages\Common\Models;

use App\Models\User;
use Packages\Traits\BelongsToBranchTrait;
use Packages\Warehouse\Models\Sale;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use BelongsToBranchTrait;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes();
    }

    public function sales()
    {
        if (config('bedaya.products_invoices_enabled')) {
            return $this->hasMany(Sale::class);
        }
        return null;
    }

    public function transactions()
    {
        return $this->user->account->transactions;
    }

    public function balanceStatusLabel(): Attribute
    {
        return Attribute::get(function () {
            $balance = $this?->user->account?->balance;
            if ($balance === 0) {
                return __('backend.balanced');
            } elseif ($balance > 0) {
                return __('backend.debit');
            } elseif ($balance < 0) {
                return __('backend.credit');
            }
            return null;
        });
    }

    public function salesTotal(): Attribute
    {
        return Attribute::get(function () {
            return $this?->sales?->sum('net_total');
        });
    }
}
