<?php

use App\Models\AboutPage;
use App\Models\ContactPage;
use App\Models\FrontSettings;
use App\Models\HomePage;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Packages\Common\Models\Dev;

if (!function_exists('dev')) {
    function dev()
    {
        if (!Schema::hasTable('dev_settings')) {
            return null;
        }

        return Dev::first();
    }
}

if (!function_exists('home_page')) {
    function home_page()
    {
        return HomePage::first();
    }
}

if (!function_exists('user')) {
    function user()
    {
        return auth()->user();
    }
}

if (!function_exists('customer')) {
    function customer()
    {
        return Auth::guard('customers')->user();
    }
}

if (!function_exists('about_page')) {
    function about_page()
    {
        return AboutPage::first();
    }
}

if (!function_exists('contact_page')) {
    function contact_page()
    {
        return ContactPage::first();
    }
}

if (!function_exists('frontSettings')) {
    function frontSettings()
    {
        return FrontSettings::first();
    }
}

if (!function_exists('settings')) {
    function settings()
    {
        return Setting::find(1);
    }
}

if (!function_exists('getMainCurrency')) {
    function getMainCurrency()
    {
        return settings()?->currency;
    }
}

if (!function_exists('getCompanyName')) {
    function getCompanyName()
    {
        return settings()?->company_name;
    }
}

if (!function_exists('getCompanyAddress')) {
    function getCompanyAddress()
    {
        return settings()?->company_address;
    }
}

if (!function_exists('getCompanyPhones')) {
    function getCompanyPhones()
    {
        return settings()?->company_phones;
    }
}

if (!function_exists('getInvoiceTagline')) {
    function getInvoiceTagline()
    {
        return settings()?->invoice_tagline;
    }
}

if (!function_exists('Tagline')) {
    function Tagline()
    {
        return settings()?->tagline;
    }
}

if (!function_exists('getMoney')) {
    function getMoney($item)
    {
        return number_format($item, 2);
    }
}

if (!function_exists('setMoney')) {
    function setMoney($item)
    {
        $formatStyle = NumberFormatter::DECIMAL;
        $formatter = new NumberFormatter('en_US', $formatStyle);

        return $formatter->format($item, 2);
    }
}
