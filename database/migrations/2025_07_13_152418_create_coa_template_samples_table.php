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
        Schema::create('coa_template_samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coa_temp_id')->constrained('c_o_a_settings')->cascadeOnDelete();
            $table->foreignId('sample_id')->constrained('samples')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_settings_samples');
    }
};
