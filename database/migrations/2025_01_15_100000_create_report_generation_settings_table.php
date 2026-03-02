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
        Schema::create('report_generation_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('frequency_id');
            $table->time('execution_time');
            $table->tinyInteger('generation_condition'); // 1: all results, 2: out of spec only
            $table->tinyInteger('report_type'); // 1: all results, 2: out of spec only
            $table->timestamps();
            
            $table->foreign('frequency_id', 'rgs_frequency_id_fk')
                  ->references('id')
                  ->on('frequencies')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('report_generation_settings', function (Blueprint $table) {
            $table->dropForeign('rgs_frequency_id_fk');
        });
        Schema::dropIfExists('report_generation_settings');
    }
};
