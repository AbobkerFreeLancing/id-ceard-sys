<?php

namespace Tests\Feature;

use App\Livewire\Cardholders\CardholderDirectory;
use App\Livewire\Cards\VerifyCard;
use App\Livewire\PortalHome;
use App\Livewire\Reissues\TrackReissue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LivewirePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_portal_home_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        Livewire::test(PortalHome::class)
            ->assertStatus(200)
            ->assertSee('المنصة الذكية لإدارة');
    }

    public function test_verify_card_page_renders_successfully(): void
    {
        $response = $this->get('/verify');
        $response->assertStatus(200);

        Livewire::test(VerifyCard::class)
            ->assertStatus(200)
            ->assertSee('التحقق من صحة البطاقة الذكية');
    }

    public function test_cardholders_directory_page_renders_successfully(): void
    {
        $response = $this->get('/cardholders');
        $response->assertStatus(200);

        Livewire::test(CardholderDirectory::class)
            ->assertStatus(200)
            ->assertSee('دليل حاملي البطاقات الذكية');
    }

    public function test_track_reissue_page_renders_successfully(): void
    {
        $response = $this->get('/track-reissue');
        $response->assertStatus(200);

        Livewire::test(TrackReissue::class)
            ->assertStatus(200)
            ->assertSee('تتبع طلبات إعادة إصدار الهوية');
    }
}
