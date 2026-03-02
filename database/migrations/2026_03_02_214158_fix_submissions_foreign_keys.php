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
        Schema::table('submissions', function (Blueprint $table) {
            $table->unsignedBigInteger('plant_id')->change();
            $table->unsignedBigInteger('sub_plant_id')->change();
            $table->unsignedBigInteger('plant_sample_id')->change();
            $table->unsignedBigInteger('sample_id')->change();
        });
    }

    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->integer('plant_id')->change();
            $table->integer('sub_plant_id')->change();
            $table->integer('plant_sample_id')->change();
            $table->integer('sample_id')->change();
        });
    }
};
