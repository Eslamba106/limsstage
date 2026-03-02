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
        Schema::create('report_generation_settings_emails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_setting_id');
            $table->unsignedBigInteger('email_id');
            $table->timestamps();
            
            $table->foreign('report_setting_id', 'rgs_emails_setting_id_fk')
                  ->references('id')
                  ->on('report_generation_settings')
                  ->onDelete('cascade');
                  
            $table->foreign('email_id', 'rgs_emails_email_id_fk')
                  ->references('id')
                  ->on('web_emails')
                  ->onDelete('cascade');
            
                $table->unique(['report_setting_id', 'email_id'], 'rgs_emails_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_generation_settings_emails', function (Blueprint $table) {
            $table->dropForeign('rgs_emails_setting_id_fk');
            $table->dropForeign('rgs_emails_email_id_fk');
        });
        Schema::dropIfExists('report_generation_settings_emails');
    }
};
