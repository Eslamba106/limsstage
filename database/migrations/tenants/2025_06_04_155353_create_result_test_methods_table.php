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
        Schema::create('result_test_methods', function (Blueprint $table) {
            $table->id();
            $table->integer('result_id') ; 
            $table->integer('test_method_id') ;  
            $table->string('status')->default('in_range');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_test_methods');
    }
};
