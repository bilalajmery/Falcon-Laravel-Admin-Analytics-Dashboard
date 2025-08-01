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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->id('requestLogsId');
            $table->text('ipAddress');
            $table->text('endPoint');
            $table->text('method');
            $table->text('status');
            $table->text('responseTime');
            $table->enum('portal', ['ADMIN'])->default('ADMIN')->index()->comment('Portal For Identify The Request');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
