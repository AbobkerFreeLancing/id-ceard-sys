<?php

namespace Packages\Accounting\Models;

use Packages\Services\Models\ServiceInvoiceItem;
use Illuminate\Database\Eloquent\Model;

class UserPaymentItem extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function userPayment()
    {
        return $this->belongsTo(UserPayment::class);
    }

    public function serviceInvoiceItem()
    {
        return $this->belongsTo(ServiceInvoiceItem::class);
    }
}
