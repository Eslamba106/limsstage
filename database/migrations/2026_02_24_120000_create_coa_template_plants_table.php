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
        Schema::create('coa_template_plants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coa_temp_id')->constrained('c_o_a_templates')->cascadeOnDelete();
            $table->foreignId('plant_id')->constrained('plants')->cascadeOnDelete();
            $table->boolean('is_default')->default(true);
            $table->timestamps();

            // Prevent duplicate plant assignments for same template
            $table->unique(['coa_temp_id', 'plant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_template_plants');
    }
};
