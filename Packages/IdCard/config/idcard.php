<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Card Dimensions (CR80 Standard in Millimeters)
    |--------------------------------------------------------------------------
    | Standard ID-1 / CR-80 card standard: 85.60 mm × 53.98 mm
    | Thickness: 0.76 mm (30 mil)
    */
    'dimensions' => [
        'width_mm' => 85.60,
        'height_mm' => 53.98,
        'default_dpi' => 300,
        'bleed_mm' => 1.5, // Bleed area for commercial plastic card printers
    ],

    /*
    |--------------------------------------------------------------------------
    | Security & Anti-Fraud Salt
    |--------------------------------------------------------------------------
    | Used to cryptographically hash QR payloads and prevent duplication.
    */
    'qr_signature_key' => env('IDCARD_QR_KEY', 'Huwia-Secure-Card-Signature-Key-2026'),

    /*
    |--------------------------------------------------------------------------
    | Photo Specifications
    |--------------------------------------------------------------------------
    | Constraints for cardholder portrait photos.
    */
    'photos' => [
        'disk' => 'public',
        'directory' => 'idcards/photos',
        'max_size_kb' => 5120, // 5MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'webp'],
        'aspect_ratio' => '3:4', // Standard portrait ratio
    ],

    /*
    |--------------------------------------------------------------------------
    | Verification Settings
    |--------------------------------------------------------------------------
    */
    'verification' => [
        'log_ip' => true,
        'log_location' => true,
        'allow_public_lookup' => true,
    ],
];
