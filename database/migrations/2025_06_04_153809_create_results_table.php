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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->foreignId('plant_id')->constrained('plants')->onDelete('cascade');
            $table->foreignId('sub_plant_id')->nullable()->constrained('plants')->onDelete('cascade');
            $table->foreignId('plant_sample_id')->nullable()->constrained('plant_samples')->onDelete('cascade');
            $table->foreignId('sample_id')->nullable()->constrained('samples')->onDelete('cascade');
            $table->enum('priority', ['high', 'normal', 'critical'])->default('normal');
            $table->dateTime('sampling_date_and_time')->nullable();
            $table->text('internal_comment')->nullable();
            $table->text('external_comment')->nullable();
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
        Schema::dropIfExists('results');
    }
};
