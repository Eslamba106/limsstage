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
        if (Schema::hasTable('coa_template_samples')) {
            Schema::table('coa_template_samples', function (Blueprint $table) {
                if (!Schema::hasColumn('coa_template_samples', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('sample_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coa_template_samples', function (Blueprint $table) {
            if (Schema::hasColumn('coa_template_samples', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
