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
        Schema::create('makes', function (Blueprint $table) {
            $table->id('makeId');
            $table->uuid('uid')->unique()->comment('Unique identifier for the make');

            $table->string('name', 100)->comment('Make name');
            $table->string('image', 100)->nullable()->comment('URL or path of the make image');

            $table->boolean('status')
                ->default(true)
                ->index()
                ->comment('Make visibility status: true = public, false = private');

            $table->timestamps();
            $table->softDeletes()->comment('Timestamp for soft deletion (recoverable)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makes');
    }
};
