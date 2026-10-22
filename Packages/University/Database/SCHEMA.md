# University Database Schema

This reference summarizes the tables created by the migrations in `Packages/University/Database/Migrations`. It is intended as project context for developers and AI assistants. The migration files are authoritative; update this document when those migrations change.

## Conventions

- Unless stated otherwise, each table has an auto-incrementing `id` primary key and Laravel `created_at` / `updated_at` timestamps.
- A field described as an FK is declared with `constrained()` (or an explicit equivalent) in its migration. Some ID-shaped fields are intentionally listed separately because their migration does not declare a database foreign-key constraint.
- Nullable fields are marked `?`. Unique constraints and enum values are called out where declared.
- `State`, `Country`, `Currency`, `Bank`, and `User` belong to other application packages or the host app; they are not defined by these University migrations.

## Reference And Organization Tables

- `absence_types`: `name`, `name_en?`, `code?`, `is_editable` (false), `is_enabled` (true).
- `academic_statuses`: `name`, `name_en?`, `code?`, `is_hold` (false), `sort_order?`, `is_enabled` (true).
- `acceptance_types`: `name`, `name_en?`, `code?`, `state_id?`, `is_active` (true). `state_id` is not constrained in this migration.
- `certificate_types`: `name`, `name_en?`, `code?`, `is_active` (true).
- `grade_scales`: `grade`, `grade_en?`, `min_mark?`, `max_mark?`, `points?` (decimal 5,2), `estimation_ar?`, `estimation_en?`, `is_pass` (true), `is_active` (true).
- `result_statuses`: `name`, `short_description?` (max 50), `slug?`, `name_en?`, `is_active` (true).
- `result_types`: `name`, `name_en?`, `is_active` (true).
- `fee_types`: `name`, `name_en?`, `code?`, `sort_order?`, `default_amount` (decimal 15,2; 0), `is_mandatory` (true), `is_active` (true), `allows_installments` (false), `allows_discount` (true), `is_refundable` (false).
- `colleges`: `name`, `name_en?`, `code?`, `code_male?`, `code_female?`, `final_level_id?`, `program_type` (CollegeProgramType enum; defaults to Bachelor), `is_active` (true). Each of the four code/level fields is unique when non-null.
- `departments`: `college_id` FK (cascade update/delete), `name`, `name_en?`, `group_no?`, `code?` (unique when non-null), `is_active` (true).
- `divisions`: `department_id` FK (cascade update/delete), `name`, `name_en?`, `is_active` (true).
- `levels`: `name`, `name_en?`, `sort_order?` (string), `is_active` (true).
- `academic_years`: `name?` (max 20), `start_date?`, `end_date?`, `is_active` (true), `is_open_for_registration` (false), `is_hold` (false).
- `semesters`: `academic_year_id?` FK, `name`, `name_en?`, `sort_order?`, `next_semester_id?` (unsigned bigint; no FK declared), `is_active` (true).
- `batches`: `ref_number?`, `college_id` FK (cascade update/delete), `department_id` FK (cascade update/delete), `academic_year_id?` FK (cascade update/delete), `name`, `name_en?`, `code?`, `batch_year?` (string length 4), `graduation_year?` (string length 4), `start_date?`, `end_date?`, `is_active` (true), `has_graduated` (false), `created_by?` (user ID; no FK declared).
- `batch_transitions`: `ref_number?`, `batch_id` FK (cascade update/delete), `from_level_id` and `to_level_id` FKs (cascade update/delete), `academic_year_id` FK (cascade update/delete), `semester_id` FK (cascade update/delete), `created_by?` (user ID; no FK declared), `transition_date`, `students_count` (0).

## Courses And Student Records

- `courses`: `name`, `name_en?`, `code?`, `credit_hours?` (string length 10), `sort_order?` (string).
- `course_allocations`: `course_id`, `department_id`, `level_id`, `state_id`, `semester_id`, `academic_year_id`, `course_order?`. These ID columns are created without `constrained()` in this migration.
- `batch_courses`: `batch_id`, `course_id`, `semester_id`, `level_id` FKs (cascade update/delete), `is_required` (false).
- `students`: `university_no?` (unique), `full_name?`, `full_name_en?`, `nationality_id?` FK to Country, `first_name?`, `first_name_en?`, `second_name?`, `second_name_en?`, `third_name?`, `third_name_en?`, `fourth_name?`, `fourth_name_en?`, `guardian_name?` (max 50), `guardian_phone?` (max 30), `guardian_relationship?` (GuardianRelationship enum), `guardian_job?`, `address?`, `permanent_address?`, `date_of_birth?`, `graduation_date?`, `email?` (unique), `passport_no?`, `national_id?`, `phone?`, `gender?`, `profile_picture?`, `password?`, `is_active` (true).
- `academic_records`: `academic_year_id?` FK, `academic_status_id?` FK, `student_id` FK, `college_id` FK, `department_id` FK, `acceptance_type_id` FK, `level_id` FK, `batch_id` FK. College, department, and batch restrict deletion; the other FK delete behavior is not explicitly overridden. Unique composite key: (`student_id`, `academic_year_id`).
- `student_identities`: `ref_number?`, `student_id` FK (cascade delete), `type` (IdentityType enum; indexed), `number?`, `issuing_authority?`, `issuing_country?`, `issue_date?`, `expiry_date?`, `attachment?`, `notes?`.
- `certificate_requests`: `student_id` FK (restrict delete), `user_id?`, `certificate_type_id?`, `serial_no?`, `certificate_language?`, `is_dual?`, `registrar_approval?` (false), `financial_clearance?` (false), `issue_date?`, `notes?`, `status?` (pending, approved, printed, rejected). User and certificate type IDs have no FK constraint declared. The column is spelled `notes` in the migration.
- `course_registrations`: `student_id`, `course_id`, `semester_id`, `academic_year_id`, `acceptance_type_id` FKs (restrict delete), `registration_date`, `status` (active, withdrawn; defaults to active).
- `lectures`: `allocation_id?`, `lecture_date?`, `lecture_time?` (max 50), `topic?` (max 255), `lecturer?` (max 255), `notes?`. `allocation_id` has cascading actions written in the migration but no `constrained()` target declaration; verify the actual database constraint before relying on it.
- `attendance_records`: `student_id` and `lecture_id` FKs (cascade update/delete), `status` (present, absent, late, excused; defaults to present), `notes?`.

## Fees, Charges, And Payments

- `fee_structures`: `name?`, `currency_id` FK, `college_id` FK, `department_id?` FK, `level_id?` FK, `state_id?`, `batch_id?`, `semester_id?` FK, `academic_year_id` FK, `acceptance_type_id?` FK, `created_by?`, `is_approved` (false), `approved_at?`, `approved_by?`, `registration_fees` (decimal 15,2; 0), `tuition_fees` (decimal 15,2; 0), `other_fees` (decimal 15,2; 0). FKs to currency/college/department/level/semester/year restrict deletion; state, batch, and user IDs have no FK constraint declared. Acceptance type has cascade-on-update but no explicit delete action.
- `fee_structure_items`: `fee_structure_id` and `fee_type_id` FKs (restrict delete), `amount` (decimal 15,2; 0), `is_mandatory` (false), `installment_eligible` (false).
- `installment_plans`: `name`, `code?` (max 60; unique), `academic_year_id?` FK (set null on delete), `fee_structure_id?` FK (set null on delete), `number_of_installments` (unsigned small integer), `distribution_method` (max 30; defaults to `percentage`; intended values percentage, fixed_amount, equal), `requires_approval` (false), `is_active` (true).
- `installment_plan_items`: `installment_plan_id` FK (cascade delete), `installment_number` (unsigned small integer), `name`, `percentage?` (decimal 7,4), `fixed_amount?` (decimal 14,2), `due_after_days` (unsigned small integer; 0), `fixed_due_date?`.
- `student_charges`: `charge_number` (max 70; unique), `student_id` FK (restrict delete), `fee_type_id` FK (restrict delete), `fee_structure_id?` FK (set null on delete), `fee_structure_item_id?` FK (set null on delete), `academic_year_id?` FK (set null on delete), `semester_id?` FK (set null on delete), `source_type?` (max 80), `source_id?` (unsigned bigint; polymorphic-style ID without FK), `description?`, `currency` (char 3; `SDG`), `gross_amount` (decimal 14,2), `discount_amount` (decimal 14,2; 0), `net_amount` (decimal 14,2), `due_date?`, `status` (max 24; defaults to `unbilled`; documented values unbilled, billed, partially_paid, paid, waived, cancelled), `created_by?` FK to users (set null on delete).
- `student_installments`: `student_id` FK (restrict delete), `student_charge_id` FK (cascade delete), `installment_plan_id?` FK (set null on delete), `installment_plan_item_id?` FK (set null on delete), `installment_number` (unsigned small integer), `description?`, `currency` (char 3; `SDG`), `amount_due` (decimal 14,2), `due_date`, `status` (max 24; defaults to `pending`; documented values pending, partially_paid, paid, overdue, deferred, cancelled), `approved_by?` FK to users (set null on delete), `approved_at?`.
- `discount_policies`: `code` (max 60; unique), `name`, `discount_type` (max 30; intended percentage or fixed_amount), `value` (decimal 14,2), `eligible_fee_type_ids?` (JSON), `eligibility_rules?` (JSON), `starts_on?`, `ends_on?`, `is_active` (true), `approved_by?` FK to users (set null on delete), `approved_at?`.
- `student_discounts`: `discount_policy_id` FK (restrict delete), `student_id` FK (restrict delete), `student_charge_id?` FK (set null on delete), `discount_amount` (decimal 14,2), `reason?`, `status` (max 20; `approved`), `approved_by?` FK to users (set null on delete), `approved_at?`.
- `invoices`: `ref_number?`, `student_id` FK (restrict delete), `academic_year_id?`, `semester_id?`, `college_id?`, `level_id?`, `bank_id?` (these FKs restrict deletion), `user_id?` FK (creator; cascade update), `currency_id` FK (restrict delete), `discount` (decimal 15,2; 0), `total` (decimal 15,2; 0), `net_total` (decimal 15,2; 0), `notes?`, `payment_status` (unpaid, partially_paid, paid; defaults to unpaid), `is_active` (true).
- `invoice_items`: `invoice_id` and `student_charge_id` FKs (restrict delete), `discount` (decimal 15,2; 0), `amount` (decimal 15,2; 0), `net_amount` (decimal 15,2; 0), `notes?`, `payment_status` (unpaid, partially_paid, paid; defaults to unpaid), `is_active` (true).
- `payments`: `ref_number?`, `receipt_no?`, nullable FKs `invoice_id`, `student_id`, `academic_year_id`, `semester_id`, `currency_id`, `college_id`, `level_id`, `bank_id` (restrict delete), `user_id?` (creator ID; no FK constraint declared), `registration_fees`, `tuition_fees`, `late_fees`, `fine_fees`, `other_fees`, `amount` (all decimal 15,2; default 0), `notes?`, `status` (pending, approved, rejected; defaults to pending), `is_distributed` (false), `is_cancelled` (false), `payment_date?`.

## Transfers And Results

- `student_transfers`: required FKs `student_id`, `from_batch_id`, `to_batch_id`, `from_college_id`, `to_college_id`, `from_department_id`, `to_department_id`, `from_division_id`, `to_division_id`, `from_level_id`, `to_level_id`, `from_academic_year_id`, `to_academic_year_id`, `from_semester_id`, `to_semester_id`, `from_fee_structure_id`, `to_fee_structure_id`, `created_by`, `approved_by`, `old_invoice_id`, `new_invoice_id` (all restrict deletion). `transfer_type` (batch_change, college_change, department_change, level_change, full_transfer; defaults to batch_change), `invoice_action` (keep_old, cancel_old, replace_old, no_invoice; defaults to replace_old), `status` (pending, approved, rejected, completed; defaults to pending), `transfer_date?`, `effective_date?`, `old_fees_total`, `new_fees_total`, `fees_difference`, `paid_before_transfer`, `remaining_after_transfer` (decimal 15,2; default 0), `reason?`, `notes?`.
- `results`: `batch_id`, `academic_year_id`, `semester_id` FKs (restrict delete), `state_id?`, `department_id?`, `level_id?`, `result_type_id?` FKs (restrict delete), `status?` (string max 30), `is_verified` (false).
- `result_details`: `student_id`, `result_id`, `course_id` FKs (restrict delete), `mark1?`, `mark2?`, `mid_term_mark?`, `final_mark?`, `total_mark?` (decimal 7,2). Absence relation is not implemented in this migration.
- `student_results`: `student_id` and `result_id` FKs (restrict delete), `gpa?` (decimal 5,2), `total_points?` and `total_points_excluding_fails?` (decimal 8,2), `credit_hours?` (decimal 5,2), `status?` (string max 30), `result_status?` (string max 30).
- `result_archives`: `result_id` FK (restrict delete), `file_path`, `title?`, `description?`, `created_by_id?` FK to users (restrict delete).

## Relationship And Implementation Notes

- Common academic path: `colleges -> departments -> divisions`; `batches` belong to a college and department and may reference an academic year. `academic_records` associates a student with the year, status, college, department, acceptance type, level, and batch.
- Course path: `course_allocations` describe a course by department, level, state, semester, and academic year; `batch_courses` attach courses to a batch/semester/level; `course_registrations` record a student's course registration for a semester and academic year.
- Assessment path: `results` scope a result set to a batch, academic year, and semester; `result_details` hold marks by student and course; `student_results` hold student-level GPA and totals; `result_archives` stores generated result files.
- Billing path: `fee_structures -> fee_structure_items` define fee amounts. `student_charges` are student liabilities, `student_installments` split charges, `student_discounts` apply reductions, and `invoice_items` link charges to invoices. `payments` records payment data.
- Many foreign keys intentionally use `restrictOnDelete`; don't assume deleting a parent will cascade. Fields listed without an FK are not protected by referential integrity merely because their names end in `_id`.
- Some enum values come from PHP enums (`CollegeProgramType`, `GuardianRelationship`, `IdentityType`) and must be checked in `Packages/University/Enums` rather than guessed from this document.
