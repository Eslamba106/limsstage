<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing foreign keys if they exist (using try-catch)
        $columns = ['plant_id', 'sub_plant_id', 'plant_sample_id', 'sample_id'];

        foreach ($columns as $column) {
            try {
                Schema::table('submissions', function (Blueprint $table) use ($column) {
                    $table->dropForeign([$column]);
                });
            } catch (\Exception $e) {
                // Foreign key doesn't exist, continue
            }
        }

        // Add foreign keys with cascade delete
        Schema::table('submissions', function (Blueprint $table) {
            $table->foreign('plant_id')
                ->references('id')
                ->on('plants')
                ->onDelete('cascade');

            $table->foreign('sub_plant_id')
                ->references('id')
                ->on('plants')
                ->onDelete('cascade');

            $table->foreign('plant_sample_id')
                ->references('id')
                ->on('plant_samples')
                ->onDelete('cascade');

            $table->foreign('sample_id')
                ->references('id')
                ->on('samples')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['plant_id']);
            $table->dropForeign(['sub_plant_id']);
            $table->dropForeign(['plant_sample_id']);
            $table->dropForeign(['sample_id']);
        });
    }
};
