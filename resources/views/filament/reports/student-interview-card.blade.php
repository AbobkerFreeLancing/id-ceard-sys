<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استمارة تقييم المقابلة الأكاديمية - {{ $student?->name ?? 'طالب' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Cairo', 'Segoe UI', Tahoma, sans-serif;
        }
        body {
            background-color: #f1f5f9;
            color: #0f172a;
            padding: 30px;
            font-size: 13px;
            line-height: 1.6;
        }
        .no-print {
            max-width: 820px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-primary { background-color: #2563eb; color: #fff; }
        .btn-primary:hover { background-color: #1d4ed8; }
        .btn-secondary { background-color: #f1f5f9; color: #475569; }
        .btn-secondary:hover { background-color: #e2e8f0; }

        .card-container {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            position: relative;
        }
        /* Header */
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .uni-details h1 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }
        .uni-details h2 {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }
        .uni-details p {
            font-size: 12px;
            color: #64748b;
        }
        .uni-logo img {
            max-height: 80px;
            object-fit: contain;
        }
        .card-title-box {
            text-align: center;
            background: #f8fafc;
            border: 2px solid #0f172a;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 24px;
        }
        .card-title-box h3 {
            font-size: 17px;
            font-weight: 800;
            color: #0f172a;
        }
        .card-title-box p {
            font-size: 12px;
            color: #64748b;
        }

        /* Student Grid */
        .section-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
            background-color: #ffffff;
        }
        .section-title {
            font-size: 14px;
            font-weight: 800;
            color: #1e3a8a;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 6px;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 24px;
        }
        .info-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 6px;
        }
        .info-label {
            font-weight: 600;
            color: #64748b;
        }
        .info-value {
            font-weight: 700;
            color: #0f172a;
        }

        /* Decision Stamp */
        .decision-section {
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .decision-passed {
            background-color: #f0fdf4;
            border: 2px solid #22c55e;
        }
        .decision-rejected {
            background-color: #fef2f2;
            border: 2px solid #ef4444;
        }
        .decision-pending {
            background-color: #fffbeb;
            border: 2px solid #f59e0b;
        }
        .decision-title {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 6px;
        }
        .decision-stamp {
            display: inline-block;
            font-size: 24px;
            font-weight: 900;
            padding: 6px 36px;
            border-radius: 30px;
            letter-spacing: 1px;
        }
        .stamp-passed {
            background-color: #22c55e;
            color: #ffffff;
        }
        .stamp-rejected {
            background-color: #ef4444;
            color: #ffffff;
        }
        .stamp-pending {
            background-color: #f59e0b;
            color: #ffffff;
        }
        .rejection-alert {
            margin-top: 14px;
            background-color: #ffffff;
            border: 1px solid #fca5a5;
            border-radius: 6px;
            padding: 12px;
            text-align: right;
        }
        .rejection-alert strong {
            color: #b91c1c;
            display: block;
            margin-bottom: 4px;
            font-size: 13px;
        }
        .rejection-alert p {
            color: #7f1d1d;
            font-size: 12px;
        }

        /* Signatures */
        .signatures {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 36px;
            padding-top: 20px;
            border-top: 1px dashed #94a3b8;
            text-align: center;
        }
        .sig-col .title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 45px;
            font-size: 12px;
        }
        .sig-col .line {
            border-bottom: 1px solid #94a3b8;
            margin: 0 15px 6px 15px;
        }
        .sig-col .desc {
            font-size: 11px;
            color: #64748b;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .card-container {
                box-shadow: none;
                border: 1px solid #0f172a;
                padding: 24px;
                max-width: 100%;
            }
            .stamp-passed, .stamp-rejected, .stamp-pending, .decision-passed, .decision-rejected, .decision-pending {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <div>
            <a href="javascript:window.history.back()" class="btn btn-secondary">
                &larr; العودة
            </a>
        </div>
        <button onclick="window.print()" class="btn btn-primary">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            طباعة الاستمارة
        </button>
    </div>

    @php
        $st = $record->status instanceof \Packages\University\Enums\StudentInterviewStatusEnum ? $record->status->value : $record->status;
    @endphp

    <div class="card-container">
        <!-- Header -->
        <div class="card-header">
            <div class="uni-details">
                <h1>{{ config('app.name', 'جامعة العلوم الصحية') }}</h1>
                <h2>أمانة الشؤون العلمية - إدارة القبول والتسجيل</h2>
                <p>لجنة المعاينات والمقابلات الأكاديمية</p>
            </div>
            <div class="uni-logo">
                <img src="{{ file_exists(public_path('static/client/invoice_logo.png')) ? asset('static/client/invoice_logo.png') : asset('static/logo.png') }}" alt="شعار الجامعة">
            </div>
        </div>

        <div class="card-title-box">
            <h3>استمارة تقييم وقرار المقابلة الأكاديمية</h3>
            <p>رقم السجل: {{ $record->ref_number ?? 'INT-' . $record->id }} | تاريخ الإصدار: {{ now()->format('Y-m-d') }}</p>
        </div>

        <!-- Student Info -->
        <div class="section-box">
            <div class="section-title">بيانات الطالب الأكاديمية</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">اسم الطالب رباعي:</span>
                    <span class="info-value">{{ $student?->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الرقم الجامعي:</span>
                    <span class="info-value" style="font-family: monospace;">{{ $student?->university_no ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الكلية:</span>
                    <span class="info-value">{{ $record->college?->name ?? $student?->academicRecord?->college?->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">العام الأكاديمي:</span>
                    <span class="info-value">{{ $record->academicYear?->name ?? $student?->academicRecord?->academicYear?->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الدفعة:</span>
                    <span class="info-value">{{ $student?->academicRecord?->batch?->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">المستوى الدراسي:</span>
                    <span class="info-value">{{ $student?->academicRecord?->level?->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Evaluation Details -->
        <div class="section-box">
            <div class="section-title">تفاصيل إجراء المقابلة واللجنة</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">تاريخ إجراء المقابلة:</span>
                    <span class="info-value">{{ $record->interview_date?->format('Y-m-d') ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">القائم بالمعاينة (المستخدم):</span>
                    <span class="info-value">{{ $record->conductedBy?->name ?? $record->interviewer_name ?? '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <span class="info-label">أعضاء لجنة المقابلة:</span>
                    <span class="info-value">{{ $record->committee_members ?? '-' }}</span>
                </div>
                <div class="info-item" style="grid-column: span 2;">
                    <span class="info-label">ملاحظات وتوصيات اللجنة:</span>
                    <span class="info-value">{{ $record->notes ?? 'لا توجد ملاحظات إضافية' }}</span>
                </div>
            </div>
        </div>

        <!-- Official Decision -->
        <div class="decision-section {{ $st === 'passed' ? 'decision-passed' : ($st === 'rejected' ? 'decision-rejected' : 'decision-pending') }}">
            <div class="decision-title">القرار الأكاديمي النهائي للجنة المقابلة</div>

            @if($st === 'passed')
                <div class="decision-stamp stamp-passed">مـجـتـاز للمقابلة بنجاح</div>
                <p style="margin-top: 10px; color: #166534; font-weight: 600;">
                    أوصت اللجنة بقبول واعتماد تسجيل الطالب أكاديمياً.
                </p>
            @elseif($st === 'rejected')
                <div class="decision-stamp stamp-rejected">مــرفـــوض</div>
                <div class="rejection-alert">
                    <strong>سبب الرفض المعتمد من اللجنة:</strong>
                    <p>{{ $record->rejection_reason ?: 'لم يتم تحديد السبب تفصيلياً.' }}</p>
                </div>
            @else
                <div class="decision-stamp stamp-pending">قيد الانتظار والمعاينة</div>
                <p style="margin-top: 10px; color: #92400e; font-weight: 600;">
                    الطالب مدرج في كشف الانتظار وفي انتظار إجراء المقابلة أو استكمال الإجراءات.
                </p>
            @endif
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="sig-col">
                <div class="title">رئيس لجنة المقابلة الأكاديمية</div>
                <div class="line"></div>
                <div class="desc">{{ $record->interviewer_name ?? 'التوقيع' }}</div>
            </div>
            <div class="sig-col">
                <div class="title">عميد الكلية</div>
                <div class="line"></div>
                <div class="desc">التوقيع والاعتماد</div>
            </div>
            <div class="sig-col">
                <div class="title">أمين الشؤون العلمية / الختم</div>
                <div class="line"></div>
                <div class="desc">الختم والتاريخ</div>
            </div>
        </div>
    </div>

</body>
</html>
