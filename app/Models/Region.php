<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected function casts(): array {
        return [
            'is_enabled' => 'boolean'
        ];
    }

    public function state() {
        return $this->belongsTo(State::class);
    }
}
