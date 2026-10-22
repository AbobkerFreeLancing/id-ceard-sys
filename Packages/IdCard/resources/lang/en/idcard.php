<?php

return [
    'module_name' => 'ID Card Management System',
    'cards' => 'ID Cards',
    'card' => 'ID Card',
    'templates' => 'Design Templates',
    'cardholders' => 'Cardholders',
    'batches' => 'Print Batches',
    'verification' => 'Security Verification',
    'verification_logs' => 'Verification Logs',

    // Statuses
    'status_draft' => 'Draft',
    'status_pending' => 'Pending Approval',
    'status_approved' => 'Approved for Printing',
    'status_in_printing' => 'In Printing',
    'status_printed' => 'Printed',
    'status_active' => 'Active & Verified',
    'status_suspended' => 'Suspended',
    'status_expired' => 'Expired',
    'status_revoked' => 'Revoked',
    'status_lost' => 'Lost / Stolen',

    // Types
    'type_student' => 'Student ID',
    'type_employee' => 'Employee ID',
    'type_visitor' => 'Visitor Badge',
    'type_member' => 'Membership Card',
    'type_contractor' => 'Contractor Pass',
    'type_event' => 'Event Badge',

    // Orientations
    'orientation_landscape' => 'Landscape',
    'orientation_portrait' => 'Portrait',

    // Verification
    'verif_valid' => 'Official Authentic Card',
    'verif_expired' => 'Card Has Expired',
    'verif_revoked' => 'Warning: Card Has Been Revoked',
    'verif_suspended' => 'Card Is Suspended',
    'verif_invalid_token' => 'Security Alert: Invalid or Forged Card Token',

    // Scanner UI
    'scanner_title' => 'Rapid ID Verification & Security Portal',
    'scanner_subtitle' => 'Scan the encrypted QR code or enter the card UID to verify authenticity',
    'scan_with_camera' => 'Scan with Camera',
    'manual_entry' => 'Manual Code Entry',
    'enter_code_placeholder' => 'Enter Card UID or Token...',
    'btn_verify' => 'Verify Now',
    'btn_reset' => 'Scan Another Card',
    'err_empty_code' => 'Please enter a card code or scan QR first.',
    'err_card_not_found' => 'No card matching this token was found in the database.',
    'cardholder_name' => 'Cardholder Name',
    'identifier_code' => 'ID / Roll Number',
    'department' => 'Department / Faculty',
    'expiry_date' => 'Expiry Date',
    'card_uid' => 'Card Security UID',
];
