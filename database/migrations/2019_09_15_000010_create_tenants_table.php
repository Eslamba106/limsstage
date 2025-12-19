<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('logo')->nullable(); 
            $table->string('domain', 255)->unique();
            $table->json('database_options')->nullable();
            $table->string('my_name', 255)->nullable();
            $table->string('tenant_id', 255)->unique()->index(); 
            $table->unsignedInteger('user_count')->default(1); 
            $table->string('setup_cost')->nullable();
            $table->string('monthly_subscription_user')->nullable();
            $table->enum('status' ,  ['active' , 'inactive' ])->default('active');     
            $table->string('email', 255)->nullable()->unique(); 
            $table->date('applicable_date')->nullable(); 
            $table->date('creation_date')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
}
