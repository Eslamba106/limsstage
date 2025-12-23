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
        Schema::create('sample_test_method_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id')->constrained('samples')->onDelete('cascade');
            $table->foreignId('test_method_id')->constrained('sample_test_methods')->onDelete('cascade');
            $table->foreignId('test_method_item_id')->constrained('test_method_items')->onDelete('cascade');
            $table->string('warning_limit')->nullable();
            $table->string('warning_limit_end')->nullable();
            $table->string('action_limit')->nullable();
            $table->string('action_limit_end')->nullable();
            $table->string('action_limit_type')->nullable();
            $table->string('warning_limit_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_test_method_items');
    }
};
