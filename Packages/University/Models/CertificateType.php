<?php

namespace Packages\University\Models;

use Illuminate\Database\Eloquent\Model;
use Packages\Traits\HasActiveScope;

class CertificateType extends Model
{
    use HasActiveScope;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
