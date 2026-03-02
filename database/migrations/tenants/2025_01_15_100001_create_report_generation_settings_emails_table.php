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
        if (!Schema::hasTable('report_generation_settings_emails')) {
            Schema::create('report_generation_settings_emails', function (Blueprint $table) {
                $table->id();
                $table->integer('report_generation_setting_id');
                $table->integer('email_id');
                $table->timestamps();
                
                $table->unique(['report_generation_setting_id', 'email_id'], 'rgs_emails_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_generation_settings_emails');
    }
};
