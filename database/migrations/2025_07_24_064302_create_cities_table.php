<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Anonymous class migration for creating the cities table
return new class extends Migration
{
    /**
     * Run the migrations to create the cities table.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id('cityId')->comment('Primary key for the city record');
            $table->uuid('uid')->unique()->comment('Unique UUID identifier for the city record');
            $table->string('name')->comment('Name of the city');
            $table->uuid('countryId')->comment('UUID reference to the parent country');
            $table->uuid('stateId')->comment('UUID reference to the parent state');
            $table->timestamps();
            $table->softDeletes()->comment('Soft deletion timestamp');
        });
    }

    /**
     * Reverse the migrations by dropping the cities table.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
