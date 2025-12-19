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
        Schema::create('result_test_method_items', function (Blueprint $table) {
            $table->id();
            $table->integer('result_test_method_id');
            $table->integer('result_id'); 
            $table->integer('test_method_item_id');
            $table->integer('submission_item')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->default('in_range'); 
            $table->string('acceptance_status')->default('pending'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_test_method_items');
    }
};
