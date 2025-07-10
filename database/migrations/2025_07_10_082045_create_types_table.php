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
        Schema::create('types', function (Blueprint $table) {
            $table->id('typeId');
            $table->uuid('uid')->unique()->comment('Unique identifier for the type');

            $table->string('name', 100)->comment('Type name');
            $table->string('image', 100)->nullable()->comment('URL or path of the Type image');

            $table->boolean('status')
                ->default(true)
                ->index()
                ->comment('Type visibility status: true = public, false = private');

            $table->timestamps();
            $table->softDeletes()->comment('Timestamp for soft deletion (recoverable)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
