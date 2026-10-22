<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class HomePage extends Model
{
    use HasFactory;

    protected $table = "home_page";
    
    protected $guarded = [];

    protected function casts(): array
    {
        return [];
    }

    public function getSeoImageUrlAttribute()
    {
        return $this->meta_image ? url(Storage::url($this->meta_image)) : url(asset('static/client/suhail_img.jpg'));
    }
}
