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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('status')->nullable();
            $table->string('transaction_id')->unique()->nullable();
            $table->text('notes')->nullable();
            $table->string('currency', 3)->default('SAR')->nullable();
            $table->string('transaction_reference' )->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
