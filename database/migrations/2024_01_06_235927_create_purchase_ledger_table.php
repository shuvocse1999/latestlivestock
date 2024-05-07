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
        Schema::create('purchase_ledger', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('invoice_date');
            $table->string("invoice_no");
            $table->string("voucer");
            $table->double("total",11,2)->nullable();
            $table->double("discount",11,2)->nullable();
            $table->double("transport_cost",11,2)->nullable();
            $table->double("grandtotal",11,2)->nullable();
            $table->double("paid",11,2)->nullable();
            $table->double("due",11,2)->nullable();
            $table->string("transaction_type");
            $table->string('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_ledger');
    }
};
