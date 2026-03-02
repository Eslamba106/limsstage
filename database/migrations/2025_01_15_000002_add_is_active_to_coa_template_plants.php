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
        if (Schema::hasTable('coa_template_plants')) {
            Schema::table('coa_template_plants', function (Blueprint $table) {
                // is_default already exists, we just need to ensure is_active exists
                if (!Schema::hasColumn('coa_template_plants', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('is_default');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coa_template_plants', function (Blueprint $table) {
            if (Schema::hasColumn('coa_template_plants', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
