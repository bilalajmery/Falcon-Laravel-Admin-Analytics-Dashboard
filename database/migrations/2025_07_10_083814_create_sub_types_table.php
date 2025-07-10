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
        Schema::create('sub_types', function (Blueprint $table) {
            $table->id('subTypeId');
            $table->uuid('uid')->unique()->comment('Unique identifier for the subType');
            $table->uuid('typeId')->comment('UUID of the parent type');

            $table->string('name', 100)->comment('subType name');
            $table->string('image', 100)->nullable()->comment('Path or URL to the subType image');

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
        Schema::dropIfExists('sub_types');
    }
};
