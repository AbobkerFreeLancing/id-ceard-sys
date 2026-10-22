<?php

use Packages\Accounting\Models\Account;
use Packages\Enum\BloodGroupEnum;
use Packages\Enum\Profile\GenderEnum;
use Packages\Enum\Profile\UserTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table
                ->foreignIdFor(Account::class, 'account_id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table
                ->enum('type', array_column(UserTypeEnum::cases(), 'value'))
                ->default(UserTypeEnum::User->value)
                ->index();
            $table->enum('account_status', ['active', 'inactive', 'banned'])->default('active');
            $table->boolean('profile_completed')->default(false); // For login with OTP
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable()->unique();
            $table->string('country_code', 10)->nullable();
            $table->string('password')->nullable();
            $table->string('username', 50)->nullable()->unique();
            $table->date('date_of_birth')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('banned_at')->nullable();
            $table->foreignId('banned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('ban_reason')->nullable();
            $table->string('profile_picture', 255)->nullable();
            $table->string('lang', 5)->default('ar');
            $table->boolean('has_admin_sidebar')->default(true);
            $table->string('address', 255)->nullable();
            $table->enum('gender', array_column(GenderEnum::cases(), 'value'))->nullable();
            $table->enum('blood_group', array_column(BloodGroupEnum::cases(), 'value'))->nullable();
            $table->string('national_id_number')->nullable();
            $table->string('passport_number')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
