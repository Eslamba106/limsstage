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
        if (!Schema::hasTable('coa_template_plants')) {
            Schema::create('coa_template_plants', function (Blueprint $table) {
                $table->id();
                $table->integer('coa_temp_id');
                $table->integer('plant_id');
                $table->boolean('is_default')->default(true);
                $table->timestamps();
                
                // Prevent duplicate plant assignments for same template
                $table->unique(['coa_temp_id', 'plant_id'], 'coa_template_plants_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_template_plants');
    }
};
