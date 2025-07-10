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
        Schema::create('models', function (Blueprint $table) {
            $table->id('modelId');
            $table->uuid('uid')->unique()->comment('Unique identifier for the model');
            $table->uuid('makeId')->comment('UUID of the parent make');

            $table->string('name', 100)->comment('model name');
            $table->string('image', 100)->nullable()->comment('Path or URL to the model image');

            $table->boolean('status')
                ->default(true)
                ->index()
                ->comment('Visibility status: true = active, false = inactive');

            $table->timestamps();
            $table->softDeletes()->comment('Timestamp for soft deletion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};
