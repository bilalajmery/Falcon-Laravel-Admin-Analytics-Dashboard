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
        Schema::create('countries', function (Blueprint $table) {
            $table->id('countryId')->comment('Primary key for the country record');
            $table->uuid('uid')->unique()->comment('Unique UUID identifier for the country record');
            $table->string('name')->unique()->comment('Name of the country');
            $table->string('code', 10)->unique()->comment('Country code (e.g., CA for California)');
            $table->timestamps();
            $table->softDeletes()->comment('Soft deletion timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
