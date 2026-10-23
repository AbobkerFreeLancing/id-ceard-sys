<?php

return [
    'module_name' => 'نظام إدارة البطاقات التعريفية',
    'cards' => 'البطاقات التعريفية',
    'card' => 'بطاقة تعريفية',
    'templates' => 'قوالب التصميم',
    'cardholders' => 'حاملو البطاقات',
    'batches' => 'دفعات الطباعة',
    'verification' => 'الفحص والتحقق الأمني',
    'verification_logs' => 'سجلات الفحص',

    // Statuses
    'status_draft' => 'مسودة',
    'status_pending' => 'قيد الاعتماد',
    'status_approved' => 'معتمدة للطباعة',
    'status_in_printing' => 'قيد الطباعة',
    'status_printed' => 'مطبوعة',
    'status_active' => 'نشطة ومعتمدة',
    'status_suspended' => 'معلقة مؤقتاً',
    'status_expired' => 'منتهية الصلاحية',
    'status_revoked' => 'ملغاة / غير صالحة',
    'status_lost' => 'مفقودة / مسروقة',

    // Types
    'type_student' => 'بطاقة طالب',
    'type_employee' => 'بطاقة موظف',
    'type_visitor' => 'بطاقة زائر',
    'type_member' => 'بطاقة عضوية',
    'type_contractor' => 'بطاقة مقاول / مورد',
    'type_event' => 'بطاقة فعالية / مؤتمر',

    // Orientations
    'orientation_landscape' => 'أفقي (Landscape)',
    'orientation_portrait' => 'عمودي (Portrait)',

    // Verification
    'verif_valid' => 'بطاقة رسمية موثقة وصالحة',
    'verif_expired' => 'البطاقة منتهية الصلاحية',
    'verif_revoked' => 'تحذير: البطاقة ملغاة ومسحوبة',
    'verif_suspended' => 'البطاقة معلقة مؤقتاً',
    'verif_invalid_token' => 'تحذير أمني: رمز الفحص غير صالح أو مزور',

    // Scanner UI
    'scanner_title' => 'بوابة الفحص والتحقق السريع من الهوية',
    'scanner_subtitle' => 'قم بمسح رمز الاستجابة السريع (QR Code) أو إدخال كود البطاقة للتأكد من أصالتها',
    'scan_with_camera' => 'مسح عبر الكاميرا',
    'manual_entry' => 'إدخال الكود يدوياً',
    'enter_code_placeholder' => 'أدخل رمز البطاقة أو الرقم الأمني (Card UID / Token)...',
    'btn_verify' => 'تحقق الآن',
    'btn_reset' => 'فحص بطاقة أخرى',
    'err_empty_code' => 'يرجى إدخال رمز البطاقة أو مسح الـ QR أولاً.',
    'err_card_not_found' => 'لم يتم العثور على أي بطاقة مسجلة بهذا الرمز في النظام.',
    'cardholder_name' => 'اسم حامل البطاقة',
    'identifier_code' => 'الرقم الأكاديمي / الوظيفي',
    'department' => 'القسم / الكلية',
    'expiry_date' => 'تاريخ الانتهاء',
    'card_uid' => 'المعرف الأمني الفريد',

    // Navigation Groups
    'nav_group_cards' => 'إدارة وتوليد البطاقات',
    'nav_group_templates' => 'تصميم وقوالب البطاقات',
    'nav_group_cardholders' => 'بيانات المنتسبين والأقسام',
    'nav_group_verification' => 'الفحص والتحقق الأمني',
];
