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
        if (!Schema::hasTable('report_generation_settings')) {
            Schema::create('report_generation_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->integer('frequency_id');
                $table->time('execution_time');
                $table->tinyInteger('generation_condition'); // 1: all results, 2: out of spec only
                $table->tinyInteger('report_type'); // 1: all results, 2: out of spec only
                $table->timestamps();
                
                // Note: Foreign keys are not used in tenant migrations as they reference shared tables
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_generation_settings');
    }
};
