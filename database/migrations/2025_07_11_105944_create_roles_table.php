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
        Schema::create('roles', function (Blueprint $table) {
            $table->id('roleId');
            $table->uuid('uid')->unique()->comment('Unique identifier for the role');
            $table->string('name', 100)->comment('Role name');
            $table->json('permission')->comment('Role permission array');
            $table->boolean('status')
                ->default(true)
                ->index()
                ->comment('Role visibility status: true = public, false = private');
            $table->timestamps();
            $table->softDeletes()->comment('Timestamp for soft deletion (recoverable)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
