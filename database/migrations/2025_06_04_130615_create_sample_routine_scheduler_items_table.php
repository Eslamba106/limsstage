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
        Schema::create('sample_routine_scheduler_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_scheduler_id')
                ->constrained('sample_routine_schedulers')
                ->onDelete('cascade');
            $table->foreignId('sample_id')
                ->constrained('samples')
                ->onDelete('cascade');
            $table->foreignId('plant_id')
                ->constrained('plants')
                ->onDelete('cascade');
            $table->foreignId('sub_plant_id')
                ->nullable()
                ->constrained('plants')
                ->onDelete('cascade');
            $table->foreignId('frequency_id')
                ->constrained('frequencies')
                ->onDelete('cascade');
            $table->string('schedule_hour')->nullable();
            $table->foreignId('test_method_ids')->nullable()->constrained('test_methods')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_routine_scheduler_items');
    }
};
