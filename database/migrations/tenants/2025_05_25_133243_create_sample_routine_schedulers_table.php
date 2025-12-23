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
        Schema::create('sample_routine_schedulers', function (Blueprint $table) {
            $table->id();
            $table->integer('sample_id');
            $table->integer('plant_id');
            $table->integer('sub_plant_id')->nullable();
            $table->string('submission_number')->nullable()->unique();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_routine_schedulers');
    }
};
