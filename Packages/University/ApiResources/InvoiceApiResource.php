<?php

namespace Packages\University\ApiResources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceApiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ref_number' => $this->ref_number,
            'amount' => $this->amount,
            'currency' => [
                'name' => $this->currency->name,
                'symbol' => $this->currency->symbol,
            ],
            'student' => [
                'name' => $this->student?->full_name,
                'university_no' => $this->student?->university_no,
            ],
            'bank' => $this->bank->name,

            'academic' => (int) $this->academicYear->name,
            'college' => $this->college->name,

            'created_at' => [
                'iso' => $this->created_at->toISOString(),
                'date' => $this->created_at->format('Y-m-d'),
                'time' => $this->created_at->format('H:i:s'),
                'datetime' => $this->created_at->format('Y-m-d H:i:s'),
                'human' => $this->created_at->diffForHumans(),
            ],
            //         // إجماليات بنود الفواتير
            //         'reg_fees' => $sumRegFees,
            //         'study_fees' => $sumStudyFees,
            //         'late_fees' => $sumLateFees,
            //         'fine_fees' => $sumFineFees,

            //         // الإجمالي المتبقي على الطالب (هذا هو المبلغ المستحق)
            //         'amount' => $totalRemaining,
            //         'invoices_count' => count($invoicesDetails),

            //         'college_code' => is_numeric($college->code ?? null)
            //             ? (int) $college->code
            //             : (int) ($firstInvoice->college_id ?? 0),
            //         'reg_status' => 1,
            //         'created_at' => $firstInvoice->created_at,
            //         'updated_at' => $firstInvoice->updated_at,
            //         'fine_percentage' => $finePercentage,

            //         // قائمة تفصيلية بكل فاتورة
            //         'invoices_details' => $invoicesDetails,
        ];
    }
}
