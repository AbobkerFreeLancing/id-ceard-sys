<?php

namespace Packages\Common\Models;

use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Dev extends Model implements HasRichContent
{
    use InteractsWithRichContent;

    protected $table = 'dev_settings';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'on_demo_mode' => 'boolean',
        ];
    }

    public function getAdminLogoUrlAttribute()
    {
        return is_null($this->admin_logo) ? asset('static/logo.png') : Storage::url($this->admin_logo);
    }

    public function getStudentDashLogoUrlAttribute()
    {
        return asset('static/logo_text.png');
    }

    public function getInvoiceLogoUrlAttribute()
    {
        return is_null($this->invoice_logo) ? asset('static/logo.png') : Storage::url($this->invoice_logo);
    }

    public function getWebsiteFaviconUrlAttribute()
    {
        return is_null($this->website_favicon)
            ? asset('static/website_favicon.png')
            : Storage::url($this->website_favicon);
    }

    public function setUpRichContent(): void
    {
        $this->registerRichContent('content')
            ->mergeTags([
                'name' => fn(): string => 'Mustafa Online',
            ])
            ->mergeTagLabels([
                'name' => 'Custoner_Name',
            ]);
    }
}
