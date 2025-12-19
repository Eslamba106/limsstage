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
        Schema::create('test_method_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_method_id')->constrained('test_methods')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('unit')->nullable();
            $table->integer('result_type')->nullable();
            $table->string('precision')->nullable();
            $table->string('lower_range')->nullable();
            $table->string('upper_range')->nullable();
            $table->enum('reportable' , [0,1])->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_method_items');
    }
};
