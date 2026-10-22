<?php

namespace Packages\Accounting\Models;

use App\Models\Setting;
use Packages\Traits\HasEnabledScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    use HasEnabledScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_enabled' => 'boolean',
            'is_main' => 'boolean',
        ];
    }

    public function getMainCurrencyAttribute()
    {
        return Setting::find(1)->currency == $this;
    }

    public function getNameRateAttribute()
    {
        return $this->name . ' - ' . $this->symbol;
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function getIsMainAttribute()
    {
        return Setting::find(1)->currency_id == $this->id ? true : false;
    }
}
