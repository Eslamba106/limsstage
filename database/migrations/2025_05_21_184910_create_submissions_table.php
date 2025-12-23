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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plant_id')->constrained('plants')->onDelete('cascade');
            $table->foreignId('sub_plant_id')->nullable()->constrained('plants')->onDelete('cascade');
            $table->foreignId('plant_sample_id')->nullable()->constrained('plant_samples')->onDelete('cascade');
            $table->foreignId('sample_id')->nullable()->constrained('samples')->onDelete('cascade');
            $table->enum('priority', ['high', 'normal', 'critical'])->default('normal');
            $table->dateTime('sampling_date_and_time')->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('submissions');
    }
};
