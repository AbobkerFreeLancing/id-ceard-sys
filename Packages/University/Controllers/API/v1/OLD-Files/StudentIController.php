<?php

namespace Packages\University\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Packages\Accounting\Models\Currency;
use Packages\University\ApiResources\InvoiceApiResource;
use Packages\University\Enums\InvoicePaymentStatusEnum;
use Packages\University\Models\Invoice;
use Packages\University\Models\Student;
use Throwable;

class StudentController extends Controller
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
    private function refreshStudentAcademicStatusIfFullyPaid(int $studentId): bool
    {
    
    }


    // ==================================================================
    // ============  2. بوابات الرسوم والخدمات الأخرى  =================
    // ==================================================================

    /**
     * -------------------------------------
     * استعلام عن كل الرسوم الأخرى غير المسددة للطالب.
     * الرسوم الأخرى = (رسوم نشاط، تأمين صحي، كرت جامعي، سكن، نقل، مكتبة...).
     *
     * الفرق عن الرسوم الدراسية:
     *   - لا توجد فواتير (invoices) هنا، بل سجلات في other_fees مباشرة.
     *   - السداد يجب أن يكون مطابقاً للإجمالي تماماً.
     */
    public function getStudentOtherInvoice(Request $request)
    {
        try {
            // ---------- (أ) التحقق من المدخلات ----------
            $unNo = $request->input('university_no');
            $apiKey = $request->input('bank_api_key');

            if (!$unNo || !is_numeric($unNo) || !$apiKey) {
                return exit('جميع المتغيرات المطلوبة غير مكتملة أو غير صحيحة (university_no, api_key).', 400);
            }

            // ---------- (ب) التحقق من البنك ----------
            $bank = $this->validateApiKey($apiKey);
            if (!$bank) {
                return exit('مفتاح التحقق (api_key) غير صحيح أو غير مصرح له.', 401);
            }

            // ---------- (ج) جلب الطالب ----------
            $student = Student::where('university_no', $unNo);
            if (!$student) {
                return exit('الرقم الجامعي غير موجود بالنظام. يرجى مراجعة مسجل الكلية.', 404);
            }

            // ---------- (د) جلب كل الرسوم الأخرى غير المدفوعة ----------
            $otherFees = DB::table('other_fees')
                ->join('other_fee_types', 'other_fees.other_fee_type_id', '=', 'other_fee_types.id')
                ->where('other_fees.student_id', $student->id)
                ->where('other_fees.is_paid', 0)
                ->orderBy('other_fees.id')
                ->select(
                    'other_fees.id as fee_id',
                    'other_fees.academic_year_id',
                    'other_fees.semester_id',
                    'other_fee_types.name as fee_name',
                    'other_fees.amount',
                    'other_fees.created_at',
                    'other_fees.updated_at',
                )
                ->get();

            if ($otherFees->isEmpty()) {
                return exit('لا توجد رسوم أو مطالبات خدمية مستحقة على هذا الطالب. الرجاء مراجعة المسجل.', 404);
            }

            // ---------- (هـ) الإجمالي ----------
            $totalAmount = round((float) $otherFees->sum('amount'), 2);
            $countFees = $otherFees->count();

            $firstFee = $otherFees->first();
            $department = DB::table('departments')->find($student->department_id);
            $college = DB::table('colleges')->find($student->college_id);

            // ---------- (و) الرد ----------
            return response()->json(
                [
                    'invoice_id' => (int) $firstFee->fee_id, // مرجعي (أول رسم)
                    'university_no' => (string) $student->university_no,
                    'bank_name' => (string) $bank->name,
                    'year_id' => (int) $firstFee->academic_year_id,
                    'student_name_arabic' => (string) $student->full_name,
                    'college_name_arabic' => (string) ($college->name ?? 'خدمات ورسوم أخرى'),
                    'department_name_arabic' => (string) ($department->name ?? 'شؤون الطلاب'),
                    'class_name_arabic' => 'عام',
                    'currency_name' => 'جنيه',
                    'currency_name_en' => 'SDG',
                    'curr_id' => 0,
                    'class_id' => 0,
                    'department_id' => (int) $student->department_id,

                    // الرسوم الدراسية لا تنطبق في هذه البوابة
                    'reg_fees' => 0,
                    'study_fees' => 0,
                    'late_fees' => 0,
                    'fine_fees' => 0,

                    // الإجمالي = مجموع كل الرسوم الأخرى
                    'amount' => $totalAmount,
                    'fees_count' => $countFees,

                    'college_code' => is_numeric($college->code ?? null)
                        ? (int) $college->code
                        : (int) $student->college_id,
                    'reg_status' => 2, // 2 = رسوم خدمات (تمييز عن 1 = دراسية)
                    'created_at' => $firstFee->created_at,
                    'updated_at' => $firstFee->updated_at,
                    'fine_percentage' => 0,

                    // قائمة الرسوم التفصيلية
                    'services_details' => $otherFees,
                ],
                200,
                [],
                JSON_UNESCAPED_UNICODE,
            );
        } catch (Throwable $e) {
            return exit('SErver ERror');
        }
    }

    /**
     * تنفيذ سداد الرسوم الأخرى.
     *
     * ملاحظات مهمة:
     *   - لا يوجد سداد جزئي هنا: المبلغ يجب أن يطابق الإجمالي تماماً.
     *   - invoice_id الممرر = id أول رسم (كما رجعه الاستعلام).
     *   - عند النجاح: تُحدَّث كل الرسوم is_paid = 1 في عملية واحدة.
     */
    public function processOtherPayment(Request $request)
    {
        try {
            // ---------- (1) التحقق من المدخلات ----------
            $v = $this->validatePayment($request);
            if ($v->fails()) {
                return exit('بيانات غير مكتملة أو غير صحيحة: ' . implode(' | ', $v->errors()->all()), 400);
            }

            // ---------- (2) استخراج القيم ----------
            $invoiceId = (int) $request->input('invoice_id');
            $unNo = $request->input('university_no');
            $amount = round((float) $request->input('Amount', $request->input('amount')), 2);
            $esalNo = (string) $request->input('esal_no');
            $esalDate = date('Y-m-d', strtotime($request->input('esal_date')));

            // ---------- (3) التحقق من البنك ----------
            $bank = $request->input('bank_api_key');
            if (!$bank) {
                return exit('مفتاح التحقق (api_key) غير صحيح أو غير مصرح له.', 401);
            }

            // ---------- (4) منع تكرار رقم الإيصال ----------
            if (DB::table('payments')->where('receipt_no', $esalNo)->exists()) {
                return exit('عذراً، رقم الإيصال مستخدم سابقاً.', 409);
            }

            // ---------- (5) جلب الطالب ----------
            $student = Student::where('university_no', $unNo);
            if (!$student) {
                return exit('الرقم الجامعي غير موجود. يرجى مراجعة مسجل الكلية.', 404);
            }

            // ---------- (6) تنفيذ السداد داخل معاملة ----------
            return DB::transaction(function () use ($student, $bank, $invoiceId, $amount, $esalNo, $esalDate) {
                // اقفل كل رسوم الطالب غير المدفوعة (لمنع تزامن)
                $fees = DB::table('other_fees')
                    ->where('student_id', $student->id)
                    ->where('is_paid', 0)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                if ($fees->isEmpty()) {
                    return exit('لا توجد رسوم خدمية مستحقة على هذا الطالب.');
                }

                // invoice_id في هذه البوابة = رقم أول رسم (كما أرجعه الاستعلام)
                if (!$fees->contains('id', $invoiceId)) {
                    return exit('رقم الفاتورة غير صحيح أو سُدد سابقاً.');
                }

                // المبلغ يجب أن يطابق الإجمالي (لا سداد جزئي هنا)
                $total = round((float) $fees->sum('amount'), 2);
                if (abs($amount - $total) > 0.001) {
                    return exit("المبلغ المدفوع ($amount) لا يطابق إجمالي المستحق ($total).", 422);
                }

                $first = $fees->first();

                // علّم كل الرسوم كمدفوعة
                DB::table('other_fees')
                    ->whereIn('id', $fees->pluck('id'))
                    ->update([
                        'is_paid' => 1,
                        'updated_at' => now(),
                    ]);

                // سجّل الدفعة (invoice_id = null لأنها رسوم خدمات)
                DB::table('payments')->insert([
                    'receipt_no' => $esalNo,
                    'student_id' => $student->id,
                    'invoice_id' => null,
                    'academic_year_id' => $first->academic_year_id,
                    'semester_id' => $first->semester_id ?? (int) DB::table('semesters')->orderBy('id')->value('id'),
                    'currency_id' => Currency::where('symbol', 'SDG')->first()->id,
                    'bank_id' => $bank->id,
                    'amount' => $amount,
                    'payment_date' => $esalDate,
                    'status' => 'approved',
                    'notes' => 'سداد خدمات ورسوم أخرى - إيصال: ' . $esalNo,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'تم استلام وتأكيد سداد الرسوم  بنجاح.',
                        'esal_no' => $esalNo,
                        'paid_amount' => $amount,
                    ],
                    200,
                    [],
                    JSON_UNESCAPED_UNICODE,
                );
            });
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') {
                return exit('عذراً، رقم الإيصال مستخدم سابقاً.', 409);
            }
            return exit('Server Error');
        } catch (Throwable $e) {
            return exit('Server Error');
        }
    }
}
