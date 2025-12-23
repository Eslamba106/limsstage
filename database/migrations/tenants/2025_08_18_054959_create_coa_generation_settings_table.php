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
        Schema::create('coa_generation_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('frequency');
            $table->time('execution_time');
            $table->tinyInteger('generation_condition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_generation_settings');
    }
};
