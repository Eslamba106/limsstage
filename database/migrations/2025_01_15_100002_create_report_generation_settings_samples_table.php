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
        Schema::create('report_generation_settings_samples', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_generation_setting_id');
            $table->unsignedBigInteger('sample_id');
            $table->timestamps();
            
            $table->foreign('report_generation_setting_id', 'rgs_samples_setting_id_fk')
                  ->references('id')
                  ->on('report_generation_settings')
                  ->onDelete('cascade');
                  
            $table->foreign('sample_id', 'rgs_samples_sample_id_fk')
                  ->references('id')
                  ->on('samples')
                  ->onDelete('cascade');
            
            $table->unique(['report_generation_setting_id', 'sample_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_generation_settings_samples', function (Blueprint $table) {
            $table->dropForeign('rgs_samples_setting_id_fk');
            $table->dropForeign('rgs_samples_sample_id_fk');
        });
        Schema::dropIfExists('report_generation_settings_samples');
    }
};
