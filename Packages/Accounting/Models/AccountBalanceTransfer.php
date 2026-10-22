<?php

namespace Packages\Accounting\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBalanceTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    public function financial_year()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function from()
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }

    public function to()
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
