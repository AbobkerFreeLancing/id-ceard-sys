<?php

namespace Tests\Unit;

use App\Models\Card;
use App\Models\Cardholder;
use App\Models\CardTemplate;
use App\Models\Organization;
use App\Services\QRCodeCryptoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QRCodeCryptoServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_and_verifies_tamper_proof_qr_payload(): void
    {
        $org = Organization::create([
            'name_ar' => 'جامعة الاختبار',
            'name_en' => 'Test University',
            'code' => 'TEST-U',
        ]);

        $holder = Cardholder::create([
            'organization_id' => $org->id,
            'full_name_ar' => 'محمد أحمد',
            'full_name_en' => 'Mohamed Ahmed',
            'national_id' => '12345678901234',
        ]);

        $template = CardTemplate::create([
            'organization_id' => $org->id,
            'name' => 'قالب افتراضي',
        ]);

        $card = Card::create([
            'cardholder_id' => $holder->id,
            'template_id' => $template->id,
            'card_uid' => 'CARD-TEST-001',
            'expires_at' => now()->addYear(),
        ]);

        $crypto = new QRCodeCryptoService;
        $payload = $crypto->generatePayload($card);

        $this->assertNotEmpty($payload);

        // Test Verification of authentic payload
        $result = $crypto->verifyPayload($payload);
        $this->assertTrue($result['is_valid']);
        $this->assertEquals('CARD-TEST-001', $result['uid']);

        // Test Detection of tampering (e.g. altered expiration date)
        $tamperedData = json_decode($payload, true);
        $tamperedData['exp'] = now()->addYears(10)->timestamp; // Hacker extending validity
        $tamperedPayload = json_encode($tamperedData);

        $tamperedResult = $crypto->verifyPayload($tamperedPayload);
        $this->assertFalse($tamperedResult['is_valid']);
        $this->assertStringContainsString('Signature mismatch', $tamperedResult['reason']);
    }
}
