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
        Schema::create('dsrsales_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
            $table->string("invoice_no");
            $table->string('payment_date')->nullable();
            $table->double("payment",11,2)->nullable();
            $table->double("discount",11,2)->nullable();
            $table->double("opening_balance",11,2)->nullable();
            $table->string('payment_type')->nullable();
            $table->string('note')->nullable();
            $table->string('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_payment');
    }
};
