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
        Schema::create('coa_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('frequency');
            $table->string('day');
            $table->time('execution_time');
            $table->string('condition');
            $table->json('sample_points');
            $table->text('email_recipients');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_settings');
    }
};
