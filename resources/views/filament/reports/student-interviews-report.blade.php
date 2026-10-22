<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كشف تقرير المقابلات الأكاديمية - {{ config('app.name', 'جامعة العلوم الصحية') }}</title>
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
            background-color: #f8fafc;
            color: #1e293b;
            padding: 24px;
            font-size: 13px;
            line-height: 1.5;
        }
        .report-wrapper {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            padding: 32px;
            border: 1px solid #e2e8f0;
        }
        /* Top Actions Bar */
        .no-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            max-width: 1100px;
            margin: 0 auto 20px auto;
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
        .btn-primary {
            background-color: #2563eb;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #1d4ed8;
        }
        .btn-secondary {
            background-color: #f1f5f9;
            color: #475569;
        }
        .btn-secondary:hover {
            background-color: #e2e8f0;
        }
        /* Header */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .university-info h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .university-info h2 {
            font-size: 15px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 2px;
        }
        .university-info p {
            font-size: 13px;
            color: #64748b;
        }
        .report-logo img {
            max-height: 85px;
            object-fit: contain;
        }
        .report-meta {
            text-align: left;
            font-size: 12px;
            color: #64748b;
        }
        .report-title-banner {
            text-align: center;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 24px;
        }
        .report-title-banner h3 {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .report-title-banner p {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 2px;
        }
        /* Stats summary cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            text-align: center;
        }
        .stat-card .label {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .stat-card .val {
            font-size: 22px;
            font-weight: 800;
        }
        .stat-card.total .val { color: #2563eb; }
        .stat-card.pending .val { color: #d97706; }
        .stat-card.passed .val { color: #16a34a; }
        .stat-card.rejected .val { color: #dc2626; }
        .stat-card.rate .val { color: #7c3aed; }
        /* Table */
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: right;
        }
        th {
            background-color: #0f172a;
            color: #ffffff;
            padding: 10px 12px;
            font-weight: 700;
            border: 1px solid #0f172a;
            white-space: nowrap;
        }
        td {
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-align: center;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .badge-passed {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }
        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }
        .rejection-text {
            color: #b91c1c;
            font-size: 11px;
            font-weight: 600;
            background-color: #fef2f2;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        /* Footer signatures */
        .signatures {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px dashed #cbd5e1;
            text-align: center;
        }
        .sig-block {
            padding: 10px;
        }
        .sig-block .role {
            font-weight: 700;
            color: #334155;
            font-size: 13px;
            margin-bottom: 50px;
        }
        .sig-block .line {
            border-bottom: 1px solid #94a3b8;
            margin: 0 20px 8px 20px;
        }
        .sig-block .name {
            font-size: 12px;
            color: #64748b;
        }
        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .report-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            th {
                background-color: #0f172a !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .stat-card {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .report-title-banner {
                background: #1e3a8a !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: A4 landscape;
                margin: 12mm;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <div>
            <a href="javascript:window.history.back()" class="btn btn-secondary">
                &larr; العودة للوحة التحكم
            </a>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                طباعة الكشف
            </button>
        </div>
    </div>

    <div class="report-wrapper">
        <!-- Header -->
        <div class="report-header">
            <div class="university-info">
                <h1>{{ config('app.name', 'جامعة العلوم الصحية') }}</h1>
                <h2>أمانة الشؤون العلمية - إدارة القبول والتسجيل</h2>
                <p>لجنة المقابلات والمعاينات الأكاديمية</p>
                @if($selectedCollege)
                    <p style="font-weight: 700; color: #1e3a8a; margin-top: 4px;">{{ $selectedCollege->name }}</p>
                @endif
            </div>

            <div class="report-logo">
                <img src="{{ file_exists(public_path('static/client/invoice_logo.png')) ? asset('static/client/invoice_logo.png') : asset('static/logo.png') }}" alt="شعار الجامعة">
            </div>

            <div class="report-meta">
                <p><strong>تاريخ التقرير:</strong> {{ now()->format('Y-m-d') }}</p>
                <p><strong>وقت الإصدار:</strong> {{ now()->format('H:i') }}</p>
                @if($selectedYear)
                    <p><strong>العام الأكاديمي:</strong> {{ $selectedYear->name }}</p>
                @endif
                <p><strong>المستخدم المصدر:</strong> {{ auth()->user()->name ?? 'الإدارة' }}</p>
            </div>
        </div>

        <!-- Banner -->
        <div class="report-title-banner">
            <h3>كشف نتائج المعاينات والمقابلات الأكاديمية للطلاب</h3>
            <p>
                @if($selectedCollege) الكلية: {{ $selectedCollege->name }} | @endif
                @if(!empty($filters['status'])) الحالة: {{ __('backend.' . ($filters['status'] === 'pending' ? 'in_waiting' : $filters['status'])) }} | @endif
                إجمالي الطلاب المدرجين: {{ $total }} طالب
            </p>
        </div>

        <!-- KPI Cards -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="label">إجمالي الطلاب</div>
                <div class="val">{{ $total }}</div>
            </div>
            <div class="stat-card pending">
                <div class="label">قيد الانتظار</div>
                <div class="val">{{ $pending }}</div>
            </div>
            <div class="stat-card passed">
                <div class="label">مجتاز</div>
                <div class="val">{{ $passed }}</div>
            </div>
            <div class="stat-card rejected">
                <div class="label">مرفوض</div>
                <div class="val">{{ $rejected }}</div>
            </div>
            <div class="stat-card rate">
                <div class="label">نسبة الاجتياز</div>
                <div class="val">{{ $passRate }}%</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">#</th>
                        <th style="width: 110px;">الرقم الجامعي</th>
                        <th>اسم الطالب رباعي</th>
                        <th>الكلية</th>
                        <th style="width: 90px; text-align: center;">تاريخ المقابلة</th>
                        <th style="width: 130px;">القائم بالمعاينة</th>
                        <th style="width: 90px; text-align: center;">النتيجة</th>
                        <th>سبب الرفض (إن وجد)</th>
                        <th>ملاحظات اللجنة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $index => $item)
                        @php
                            $st = $item->status instanceof \Packages\University\Enums\StudentInterviewStatusEnum ? $item->status->value : $item->status;
                        @endphp
                        <tr>
                            <td style="text-align: center; font-weight: 700;">{{ $index + 1 }}</td>
                            <td style="font-family: monospace; font-weight: 700;">{{ $item->student?->university_no ?? '-' }}</td>
                            <td style="font-weight: 700; color: #0f172a;">{{ $item->student?->name ?? '-' }}</td>
                            <td>{{ $item->college?->name ?? '-' }}</td>
                            <td style="text-align: center;">{{ $item->interview_date?->format('Y-m-d') ?? '-' }}</td>
                            <td style="font-size: 11px; font-weight: 600;">{{ $item->conductedBy?->name ?? $item->interviewer_name ?? '-' }}</td>
                            <td style="text-align: center;">
                                @if($st === 'passed')
                                    <span class="badge badge-passed">مجتاز</span>
                                @elseif($st === 'rejected')
                                    <span class="badge badge-rejected">مرفوض</span>
                                @else
                                    <span class="badge badge-pending">في الانتظار</span>
                                @endif
                            </td>
                            <td>
                                @if($st === 'rejected' && $item->rejection_reason)
                                    <span class="rejection-text">{{ $item->rejection_reason }}</span>
                                @else
                                    <span style="color: #94a3b8;">-</span>
                                @endif
                            </td>
                            <td style="font-size: 11px; color: #475569;">
                                {{ $item->notes ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 30px; color: #64748b;">
                                لا توجد سجلات مطابقة للشروط المحددة
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="sig-block">
                <div class="role">رئيس لجنة المقابلات الأكاديمية</div>
                <div class="line"></div>
                <div class="name">التوقيع والاعتماد</div>
            </div>
            <div class="sig-block">
                <div class="role">عميد الكلية المعنية</div>
                <div class="line"></div>
                <div class="name">التوقيع والاعتماد</div>
            </div>
            <div class="sig-block">
                <div class="role">أمين الشؤون العلمية / الختم الرسمي</div>
                <div class="line"></div>
                <div class="name">التوقيع والختم</div>
            </div>
        </div>
    </div>

</body>
</html>
