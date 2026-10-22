<?php

namespace Packages\University\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultArchive extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
