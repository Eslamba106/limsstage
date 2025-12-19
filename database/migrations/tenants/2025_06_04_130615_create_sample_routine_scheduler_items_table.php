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
            $table->integer('sample_scheduler_id')
                ;
            $table->integer('sample_id')
               ;
            $table->integer('plant_id')
              ;
            $table->integer('sub_plant_id')
                ->nullable()
                 ;
            $table->integer('frequency_id')
                 ;
            $table->string('schedule_hour')->nullable();
            $table->integer('test_method_ids')->nullable()->constrained('test_methods')->onDelete('cascade');
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
