<?php

namespace Packages\University\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Enum\PaymentStatusEnum;
use Packages\University\ApiResources\StudentChargeApiResource;
use Packages\University\Models\Student;
use Packages\University\Models\StudentCharge;
use Throwable;

class StudentInvoiceApiController extends Controller
{
    public function getInvoiceByRefernce(Request $request)
    {
        $request->validate(
            [
                'ref_number' => 'required|exists:student_charges,ref_number',
                'bank_api_key' => 'required|exists:banks,api_key',
            ],
            [
                'ref_number.exists' => __('backend.no_invoice_with_ref'),
            ],
        );

        $charge = StudentCharge::where('ref_number', $request->ref_number)->first();
        $student = $charge->student;

        try {
            $invoices = StudentCharge::where('student_id', $student->id)
                ->whereIn('status', [PaymentStatusEnum::UNPAID->value])
                ->latest()
                ->get();

            if ($invoices->isEmpty()) {
                $hasAnyInvoice = StudentCharge::where('student_id', $student->id)->exists();
                if (!$hasAnyInvoice) {
                    return response()->json(
                        [
                            'message' => __('university::messages.student_no_invoice'),
                            'status_code' => 404,
                        ],
                        404,
                    );
                }
                return response()->json(
                    [
                        'message' => 'تم سداد فواتير هذا الطالب أو جميع الفواتير ملغاة/معلقة.',
                        'status_code' => 400,
                    ],
                    400,
                );
            }

            return response()->json([
                'message' => __('backend.invoice_details'),
                'university_name' => 'جامعة العلوم الصحية',
                'data' => new StudentChargeApiResource($charge),
            ]);
        } catch (Throwable $e) {
            return exit('system issue!');
        }
    }

    public function payInvoiceByRefernce(Request $request)
    {
        $validated = $request->validate(
            [
                'ref_number' => ['required', 'exists:student_charges,ref_number'],
                'amount' => ['required', 'numeric', 'gt:0'],
                'receipt_no' => ['string'],
                'esal_date' => ['nullable', 'date'],
            ],
            [
                'ref_number.exists' => __('backend.no_invoice_with_ref'),
            ],
        );

        $charge = StudentCharge::where('ref_number', $validated['ref_number'])->first();
        $student = $charge->student;

        if (!$student) {
            return response()->json(
                [
                    'message' => 'الطالب غير موجود بالنظام.',
                    'status_code' => 404,
                ],
                404,
            );
        }

        if ($charge->status === PaymentStatusEnum::PAID->value) {
            return response()->json(
                [
                    'message' => __('university::messages.invoice_alredy_paid'),
                    'status_code' => 400,
                ],
                400,
            );
        }

        // التحقق من أن المبلغ المراد دفعه لا يتجاوز المبلغ المتبقي
        if ($validated['amount'] > $charge->PaymentsRemaining) {
            return response()->json(
                [
                    'message' =>
                        'المبلغ المدفوع أكبر من المتبقي على الفاتورة. المبلغ المتبقي هو: ' . $charge->PaymentsRemaining,
                    'status_code' => 400,
                ],
                400,
            );
        }

        try {
            DB::beginTransaction();

            $payment = $charge->payments()->create([
                'amount' => $validated['amount'],
                'receipt_no' => $validated['receipt_no'] ?? null,
                'status' => 'approved',
            ]);

            $charge->update([
                'status' =>
                    $payment->charge->PaymentsRemaining == 0
                        ? PaymentStatusEnum::PAID->value
                        : PaymentStatusEnum::PARTIALLY_PAID->value,
            ]);

            DB::commit();

            return response()->json(
                [
                    'message' => 'تم سداد الدفعة بنجاح.',
                    'status_code' => 200,
                    'data' => [
                        'charge' => new StudentChargeApiResource($charge->fresh(['payments', 'student'])),
                        'payment_details' => $payment,
                    ],
                ],
                200,
            );
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json(
                [
                    'message' => 'حدث خطأ أثناء معالجة عملية السداد.',
                    'error' => config('app.debug') ? $e->getMessage() : null,
                    'status_code' => 500,
                ],
                500,
            );
        }
    }

    public function getInvoicesByUniversityNumber(Request $request)
    {
        $validated = $request->validate([
            'university_no' => ['required', 'exists:students,university_no'],
            'bank_api_key' => ['required', 'exists:banks,api_key'],
        ]);

        try {
            $student = Student::where('university_no', $validated['university_no'])->firstOrFail();

            $invoices = StudentCharge::where('student_id', $student->id)
                ->where('status', PaymentStatusEnum::UNPAID)
                ->get();

            if ($invoices->isEmpty()) {
                $hasAnyInvoice = StudentCharge::where('student_id', $student->id)->exists();

                if (!$hasAnyInvoice) {
                    return response()->json(
                        [
                            'message' => __('university::messages.student_no_invoice'),
                            'status_code' => 404,
                        ],
                        404,
                    );
                }

                return response()->json(
                    [
                        'message' => __('university::messages.invoices_already_paid_or_cancelled'), // Recommended: Move to lang file
                        'status_code' => 400,
                    ],
                    400,
                );
            }

            return response()->json([
                'message' => __('backend.invoice_details'),
                'university_name' => 'جامعة العلوم الصحية',
                'data' => StudentChargeApiResource::collection($invoices),
                'amount' => $invoices->sum('net_amount'), // Cleaner than pluck->sum()
            ]);
        } catch (Throwable $e) {
            // Log the exception for debugging purposes
            report($e);

            return response()->json(
                [
                    'message' => 'System issue occurred.',
                    'status_code' => 500,
                ],
                500,
            );
        }
    }

    public function payInvoicesByUniversityNumber(Request $request)
    {
        //
    }
}
