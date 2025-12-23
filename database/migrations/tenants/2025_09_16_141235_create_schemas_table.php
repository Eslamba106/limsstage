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
        Schema::create('schemas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('scan_barcode');
            $table->tinyInteger('test_method_management');
            $table->tinyInteger('test_method_count')->nullable();
            $table->tinyInteger('unit');
            $table->tinyInteger('unit_count')->nullable();
            $table->tinyInteger('result_types');
            $table->tinyInteger('result_types_count')->nullable();
            $table->tinyInteger('sample_management');
            $table->tinyInteger('sample_count')->nullable();
            $table->tinyInteger('assig_test_to_sample');
            $table->tinyInteger('plants');
            $table->tinyInteger('plants_count')->nullable();
            $table->tinyInteger('create_sample');
            $table->tinyInteger('create_sample_count')->nullable();
            $table->tinyInteger('toxic_degree');
            $table->tinyInteger('toxic_degree_count')->nullable();
            $table->tinyInteger('submissions_management');
            $table->tinyInteger('submissions_count')->nullable();
            $table->tinyInteger('sample_routine_scheduler');
            $table->tinyInteger('sample_routine_scheduler_count')->nullable();
            $table->tinyInteger('frequencies');
            $table->tinyInteger('frequencies_count')->nullable();
            $table->tinyInteger('results');
            $table->tinyInteger('results_count')->nullable();
            $table->tinyInteger('template_designer_list');
            $table->tinyInteger('template_designer_count')->nullable();
            $table->tinyInteger('coa_generation_settings');
            $table->tinyInteger('coa_generation_settings_count')->nullable();
            $table->tinyInteger('certificate_management');
            $table->tinyInteger('certificate_count')->nullable();
            $table->tinyInteger('emails');
            $table->tinyInteger('emails_count')->nullable();
            $table->tinyInteger('users');
            $table->tinyInteger('users_count')->nullable();
            $table->tinyInteger('clients');
            $table->tinyInteger('clients_count')->nullable();
            $table->tinyInteger('roles');
            $table->tinyInteger('system_setup'); 
            $table->string('price'); 
            $table->string('currency'); 
            $table->string('name'); 
            $table->string('display')->nullable();
            $table->string('status')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemas');
    }
};
