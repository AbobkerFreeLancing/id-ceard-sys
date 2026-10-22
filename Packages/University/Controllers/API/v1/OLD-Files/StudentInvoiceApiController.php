<?php

namespace Packages\University\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\Currency;
use Packages\University\ApiResources\InvoiceApiResource;
use Packages\University\Enums\InvoicePaymentStatusEnum;
use Illuminate\Validation\ValidationException;
use Packages\University\Models\Invoice;
use Packages\University\Models\Payment;
use Packages\University\Models\Student;
use Throwable;

class StudentInvoiceApiControllerxs extends Controller
{
    /**
     * حساب إجمالي المبلغ المدفوع فعلياً على فاتورة معيّنة.
     * الفلترة على:
     *   - invoice_id محدد
     *   - status = 'approved' (تجاهل payments المرفوضة)
     *   - is_cancelled = 0 (تجاهل الملغاة)
     */
    private function totalPaid(int $invoiceId): float
    {
        return round(
            (float) DB::table('payments')
                ->where('invoice_id', $invoiceId)
                ->where('status', 'approved')
                ->where('is_cancelled', 0)
                ->sum('amount'),
            2,
        );
    }

    /**
     * ================================================================
     * تحويل الحالة الأكاديمية إلى "مسجل" عند اكتمال السداد
     * ================================================================
     * الشرط:
     *   - كل الفواتير النشطة (is_active=1) للطالب لها payment_status='paid'.
     *
     * الخطوات:
     *   1) التحقق من وجود فاتورة نشطة واحدة على الأقل (لا نُفعّل من لا فواتير له).
     *   2) التحقق من عدم وجود فاتورة نشطة غير مسددة.
     *   3) جلب id الحالة "مسجل" عبر كودها REG (أكثر أماناً من id=1 ثابت).
     *   4) تحديث students.academic_status_id + is_active.
     *
     * @return bool true إذا حُدّثت الحالة، false إن لم يُستوفَ الشرط.
     */
    private function refreshStudentAcademicStatusIfFullyPaid()
    {
    
    }

    public function show(Request $request)
    {
        $request->validate([
            'university_no' => 'required|exists:students,university_no',
            'bank_api_key' => 'required|exists:banks,api_key',
        ]);

        $student = Student::where('university_no', $request->university_no)->first();

        try {
            if (!$student->is_active) {
                return response()->json(
                    [
                        'message' => __('university::messages.student_account_inactive'),
                        'status_code' => 401,
                    ],
                    401,
                );
            }

            // ---------- (هـ) جلب كل الفواتير النشطة غير المسددة ----------
            $invoices = Invoice::where('student_id', $student->id)
                ->where('is_active', true)
                ->where('payment_status', '!=', InvoicePaymentStatusEnum::Paid->value)
                ->latest()
                ->get();

            // لا توجد فواتير إطلاقاً؟
            if ($invoices->isEmpty()) {
                $hasAnyInvoice = DB::table('invoices')->where('student_id', $student->id)->exists();
                if (!$hasAnyInvoice) {
                    return response()->json(
                        [
                            'message' => __('university::messages.student_no_invoice'),
                            'status_code' => 404,
                        ],
                        404,
                    );
                }
                // توجد فواتير لكن كلها مسددة أو ملغاة
                return response()->json(
                    [
                        'message' => 'تم سداد فواتير هذا الطالب بالكامل أو جميع الفواتير ملغاة/معلقة.',
                        'status_code' => 400,
                    ],
                    400,
                );
            }

            // ---------- (و) حساب المتبقي لكل فاتورة + الإجمالي ----------
            //     نتجاهل أي فاتورة رصيدها الفعلي صفر (payment_status لم يُحدَّث).
            $invoicesDetails = [];
            $totalRemaining = 0.0;

            foreach ($invoices as $inv) {
                $paid = $this->totalPaid($inv->id);
                $remaining = round((float) $inv->amount - $paid, 2);

                if ($remaining <= 0) {
                    continue; // فاتورة مدفوعة فعلياً، تجاهلها
                }

                $invoicesDetails[] = [
                    'invoice_id' => (int) $inv->id,
                    'academic_year_id' => (int) $inv->academic_year_id,
                    'semester_id' => (int) ($inv->semester_id ?? 0),
                    'college_id' => (int) ($inv->college_id ?? 0),
                    'level_id' => (int) ($inv->level_id ?? 0),
                    'registration_fees' => (float) $inv->registration_fees,
                    'tuition_fees' => (float) $inv->tuition_fees,
                    'late_fees' => (float) $inv->late_fees,
                    'fine_fees' => (float) $inv->fine_fees,
                    'total_amount' => (float) $inv->amount,
                    'paid_amount' => $paid,
                    'remaining_amount' => $remaining,
                    'payment_status' => $inv->payment_status->value,
                    'created_at' => $inv->created_at,
                    'updated_at' => $inv->updated_at,
                ];

                $totalRemaining += $remaining;
            }

            $totalRemaining = round($totalRemaining, 2);

            if ($totalRemaining <= 0) {
                return exit('تم استيفاء كامل مبلغ جميع الفواتير. يرجى مراجعة المسجل لتحديث الحالة.', 400);
            }

            // ---------- (ز) الفاتورة المرجعية للأسماء العامة ----------
            $firstInvoice = $invoices->first();

            $college = $firstInvoice->college_id ? DB::table('colleges')->find($firstInvoice->college_id) : null;
            $level = $firstInvoice->level_id ? DB::table('levels')->find($firstInvoice->level_id) : null;
            $currency = DB::table('currencies')->find($firstInvoice->currency_id);
            $department = DB::table('departments')->find($student->department_id);

            // ---------- (ح) إجماليات كل بند (مجموع كل الفواتير) ----------
            $sumRegFees = round((float) $invoices->sum('registration_fees'), 2);
            $sumStudyFees = round((float) $invoices->sum('tuition_fees'), 2);
            $sumLateFees = round((float) $invoices->sum('late_fees'), 2);
            $sumFineFees = round((float) $invoices->sum('fine_fees'), 2);

            // نسبة الغرامة = إجمالي الغرامات ÷ إجمالي الرسوم الدراسية
            $finePercentage = $sumStudyFees > 0 ? round(($sumFineFees / $sumStudyFees) * 100, 2) : 0.0;

            return response()->json([
                'message' => __('backend.invoice_details'),
                'university_name' => 'جامعة العلوم الصحية',
                'data' => new InvoiceApiResource($firstInvoice),
            ]);
        } catch (Throwable $e) {
            return exit('tuition.inquiry');
        }
    }

    public function makePayment(Request $request)
    {
        $validated = $request->validate(
            [
                'ref_number' => ['required', 'string', 'exists:invoices,ref_number'],
                'amount' => ['required', 'numeric', 'gt:0'],
                'receipt_no' => ['string'],
                'esal_date' => ['nullable', 'date'],
            ],
            [
                'ref_number.exists' => __('backend.no_invoice_with_ref'),
            ],
        );

        $invoice = Invoice::where('ref_number', $validated['ref_number'])->first();
        $student = $invoice->student;


        if (!$student) {
                return response()->json([
                'message' => 'الطالب غير موجود بالنظام.',
                'status_code' => 404,
                ], 404);
        }

         try {
        $result = DB::transaction(function () use ($validated, $invoice,$student) {
            // استخدام رقم الفاتورة لتحديد الطالب.
            $invoice->lockForUpdate()
                ->first();

            if (! $invoice) {
                throw ValidationException::withMessages([
                    'ref_number' => 'الفاتورة غير موجودة.',
                ]);
            }

            if (! $student->id || ! $invoice->student()->exists()) {
                throw ValidationException::withMessages([
                    'ref_number' => 'الطالب المرتبط بالفاتورة غير موجود.',
                ]);
            }

            $payAll = (bool) ($validated['pay_all'] ?? false);

            // جلب الفواتير المستهدفة وقفل سجلاتها.
            $invoicesQuery = Invoice::query()
                ->where('student_id', $student->id)
                ->where('is_active', 1)
                ->whereIn('payment_status', [
                    'unpaid',
                    'partially_paid',
                ]);

            if (! $payAll) {
                $invoicesQuery->whereKey($invoice->id);
            }

            $invoices = $invoicesQuery
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($invoices->isEmpty()) {
                throw ValidationException::withMessages([
                    'ref_number' => 'لا توجد فواتير مستحقة للسداد.',
                ]);
            }

            // حساب المبالغ المتبقية قبل تسجيل أي دفعة.
            $balances = [];
            $totalRemaining = 0.0;

            foreach ($invoices as $invoice) {
                $paid = (float) $this->totalPaid($invoice->id);
                $remaining = round((float) $invoice->amount - $paid, 2);

                if ($remaining < 0) {
                    throw ValidationException::withMessages([
                        'amount' => 'يوجد تجاوز في إجمالي المدفوعات المسجلة لإحدى الفواتير.',
                    ]);
                }

                if ($remaining > 0) {
                    $balances[$invoice->id] = $remaining;
                    $totalRemaining = round(
                        $totalRemaining + $remaining,
                        2
                    );
                }
            }

            if ($totalRemaining <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'تم سداد جميع الفواتير المستهدفة.',
                ]);
            }

            $amount = round((float) $validated['amount'], 2);

            if ($payAll && abs($amount - $totalRemaining) > 0.001) {
                throw ValidationException::withMessages([
                    'amount' => "يجب أن يساوي المبلغ إجمالي المستحق: {$totalRemaining}.",
                ]);
            }

            if (! $payAll && $amount > $totalRemaining) {
                throw ValidationException::withMessages([
                    'amount' => "المبلغ يتجاوز المتبقي: {$totalRemaining}.",
                ]);
            }

            // منع تكرار رقم الإيصال الأصلي في سجلات الدفع.
            $receiptExists = DB::table('payments')
                ->where('receipt_no', $validated['receipt_no'])
                ->exists();

            if ($receiptExists) {
                throw ValidationException::withMessages([
                    'receipt_no' => 'رقم الإيصال مستخدم مسبقاً.',
                ]);
            }

            $remainingToDistribute = $amount;
            $createdPayments = [];

            foreach ($balances as $invoiceId => $remaining) {
                if ($remainingToDistribute <= 0) {
                    break;
                }

                $payNow = min($remaining, $remainingToDistribute);
                $invoice = $invoices->firstWhere('id', $invoiceId);

                // إنشاء رقم داخلي مميز لكل فاتورة.
                $receiptNo = $payAll ? $validated['receipt_no'] . '-' . $invoiceId : $validated['receipt_no'];


                // Create Payment
                Payment::create([
                    'receipt_no' => $receiptNo,
                    'student_id' => $student->id,
                    'invoice_id' => $invoice->id,
                    'currency_id' => $invoice->currency_id,
                    'amount' => $payNow,
                    'payment_date' => $validated['esal_date'] ?? now()->toDateString(),
                    'status' => 'approved',
                    'notes' => 'سداد عبر البنك، مرجع الإيصال: ' . $validated['receipt_no'],
                ]);
                

                $newPaid = round(
                    (float) $this->totalPaid($invoice->id) + $payNow,
                    2
                );

                $newRemaining = round(
                    (float) $invoice->amount - $newPaid,
                    2
                );

                DB::table('invoices')
                    ->where('id', $invoice->id)
                    ->update([
                        'payment_status' => $newRemaining <= 0
                            ? 'paid'
                            : 'partially_paid',
                        'updated_at' => now(),
                    ]);

                $createdPayments[] = [
                    'invoice_id' => $invoice->id,
                    'receipt_no' => $receiptNo,
                    'amount' => round($payNow, 2),
                ];

                $remainingToDistribute = round(
                    $remainingToDistribute - $payNow,
                    2
                );
            }

            if ($remainingToDistribute > 0.001) {
                throw ValidationException::withMessages([
                    'amount' => 'تعذر توزيع كامل المبلغ على الفواتير.',
                ]);
            }

            $this->refreshStudentAcademicStatusIfFullyPaid($student->id);

            return [
                'student_id' => $student->id,
                'receipt_no' => $validated['receipt_no'],
                'paid_amount' => $amount,
                'payments' => $createdPayments,
            ];
        }, 3);

        return response()->json([
            'status' => true,
            'message' => 'تم تسجيل عملية السداد بنجاح.',
            ...$result,
        ], 200, [], JSON_UNESCAPED_UNICODE);

    } catch (ValidationException $e) {
        throw $e;

    } catch (QueryException $e) {
        report($e);

        if ($e->getCode() === '23000') {
            return response()->json([
                'status' => false,
                'message' => 'تعذر تسجيل العملية بسبب تكرار رقم مرجعي أو مخالفة قيد في قاعدة البيانات.',
            ], 409, [], JSON_UNESCAPED_UNICODE);
        }

        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ أثناء معالجة عملية السداد.',
        ], 500, [], JSON_UNESCAPED_UNICODE);

    } catch (Throwable $e) {
        report($e);

        return response()->json([
            'status' => false,
            'message' => 'حدث خطأ داخلي أثناء معالجة عملية السداد.',
        ], 500, [], JSON_UNESCAPED_UNICODE);
    }
    }


}
