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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('result_id');
            $table->integer('sample_id')->nullable();
            $table->string('authorized_id')->nullable();
            $table->integer('temp_id')->nullable();
            $table->integer('generated_by')->nullable();
            $table->string('client')->nullable();
            $table->date('generated_Date')->nullable();
            $table->string('coa_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
