<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use App\Models\Category;
use App\Models\ContactPage;
use App\Models\FaqPage;
use App\Models\HomePage;
use App\Models\PrivacyPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontPagesSeeder extends Seeder
{
    public function run()
    {
        HomePage::create();
        AboutPage::create();
        ContactPage::create();
        FaqPage::create();
        PrivacyPage::create();
    }
}
