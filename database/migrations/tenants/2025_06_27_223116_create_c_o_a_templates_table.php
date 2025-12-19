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
        Schema::create('c_o_a_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('value')->nullable();

            $table->tinyInteger('header_information')->default(0);
            $table->tinyInteger('company_logo')->default(0);
            $table->tinyInteger('company_name')->default(0);
            $table->tinyInteger('laboratory_accreditation')->default(0);                                                                                           
            $table->tinyInteger('coa_number')->default(0);
            $table->tinyInteger('lims_number')->default(0);
            $table->tinyInteger('report_date')->default(0);

            // Sample Information
            $table->tinyInteger('sample_information')->default(0);
            $table->tinyInteger('sample_plant')->default(0);
            $table->tinyInteger('sample_subplant')->default(0);
            $table->tinyInteger('sample_point')->default(0);
            $table->tinyInteger('sample_description')->default(0);
            $table->tinyInteger('batch_lot_number')->default(0);
            $table->tinyInteger('date_received')->default(0);
            $table->tinyInteger('date_analyzed')->default(0);
            $table->tinyInteger('date_authorized')->default(0);

            // Test Results
            $table->tinyInteger('test_results')->default(0);
            $table->tinyInteger('component_name')->default(0);
            $table->tinyInteger('specification')->default(0);
            $table->tinyInteger('test_method')->default(0);
            $table->tinyInteger('pass_fail_status')->default(0);
            $table->tinyInteger('results')->default(0);
            $table->tinyInteger('analyst')->default(0);
            $table->tinyInteger('unit')->default(0);

            // Authorization
            $table->tinyInteger('authorization')->default(0);
            $table->tinyInteger('analyzed_by')->default(0);
            $table->tinyInteger('authorized_by')->default(0);
            $table->tinyInteger('digital_signature')->default(0);
            $table->tinyInteger('comments')->default(0);

            // Footer Information
            $table->tinyInteger('footer_information')->default(0);
            $table->tinyInteger('disclaimer_text')->default(0);
            $table->tinyInteger('laboratory_contact_information')->default(0);
            $table->tinyInteger('page_numbers')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_o_a_settings');
    }
};
