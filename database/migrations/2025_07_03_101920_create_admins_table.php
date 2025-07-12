<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('adminId')->comment('Primary key for admin');
            $table->uuid('uid')->unique()->comment('Universally unique identifier for admin');
            $table->uuid('roleId')->comment('UUID of the role');

            $table->string('name', 100)->index()->comment('Full name of the admin');
            $table->string('email')->unique()->comment('Unique email address of the admin');
            $table->string('phone', 20)->nullable()->index()->comment('Optional phone number of the admin');

            $table->string('profile')->nullable()->comment('Optional profile of the admin');
            $table->string('cover')->nullable()->comment('Optional cover of the admin');

            $table->string('otp', 6)->nullable()->comment('One-time password for verification');
            $table->boolean('twoStepVerification')->default(false)->comment('twoStepVerification for account secure');
            $table->boolean('status')->default(true)->index()->comment('Account status: public or private');

            $table->string('password')->comment('Hashed login password');

            $table->enum('type', ['ADMIN', 'EMPLOYEE'])->default('ADMIN')->index()->comment('User type: ADMIN or EMPLOYEE');

            $table->timestamps();
            $table->softDeletes()->comment('Soft delete timestamp for recoverable deletion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
