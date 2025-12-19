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
        Schema::create('certificate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->constrained('certificates')->onDelete('cascade');
            $table->foreignId('result_test_method_id')->constrained('result_test_methods')->onDelete('cascade');
            $table->foreignId('result_id')->constrained('results')->onDelete('cascade');
            $table->foreignId('test_method_item_id')->constrained('test_method_items')->onDelete('cascade');
            $table->string('result')->nullable();
            $table->string('status')->default('in_range');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_items');
    }
};
