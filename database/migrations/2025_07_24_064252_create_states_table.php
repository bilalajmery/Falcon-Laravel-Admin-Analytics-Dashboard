<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Anonymous class migration for creating the states table
return new class extends Migration
{
    /**
     * Run the migrations to create the states table.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id('stateId')->comment('Primary key for the state record');
            $table->uuid('uid')->unique()->comment('Unique UUID identifier for the state record');
            $table->uuid('countryId')->comment('UUID reference to the parent country');
            $table->string('name')->unique()->comment('Name of the state');
            $table->string('code', 10)->unique()->comment('State code (e.g., CA for California)');
            $table->timestamps();
            $table->softDeletes()->comment('Soft deletion timestamp');
        });
    }

    /**
     * Reverse the migrations by dropping the states table.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
