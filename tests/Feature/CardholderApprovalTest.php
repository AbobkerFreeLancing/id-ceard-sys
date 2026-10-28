<?php

namespace Tests\Feature;

use App\Enums\CardholderAuditStatus;
use App\Models\Cardholder;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardholderApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_cardholder_audit_lifecycle(): void
    {
        $org = Organization::create([
            'name_ar' => 'هيئة التدقيق',
            'name_en' => 'Audit Org',
            'code' => 'AUDIT-01',
        ]);

        $holder = Cardholder::create([
            'organization_id' => $org->id,
            'full_name_ar' => 'علي محمود',
            'full_name_en' => 'Ali Mahmoud',
            'national_id' => '98765432101234',
            'audit_status' => CardholderAuditStatus::PendingReview,
        ]);

        $this->assertFalse($holder->isApproved());
        $this->assertEquals(CardholderAuditStatus::PendingReview, $holder->audit_status);

        // Approve Cardholder
        $holder->update([
            'audit_status' => CardholderAuditStatus::Approved,
        ]);

        $this->assertTrue($holder->fresh()->isApproved());
    }
}
