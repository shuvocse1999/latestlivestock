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
        Schema::create('dsrsales_entry', function (Blueprint $table) {
            $table->id();
            $table->string("invoice_no");
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->double("carton",11,2)->nullable();
            $table->double("piece",11,2)->nullable();
            $table->double("qty",11,2)->nullable();
            $table->double("free",11,2)->nullable();
            $table->double("returnscarton",11,2)->nullable();
            $table->double("returnspiece",11,2)->nullable();
            $table->double("returnsqty",11,2)->nullable();
            $table->double("damage",11,2)->nullable();
            $table->double("purchase_price",11,2)->nullable();
            $table->double("sales_price",11,2)->nullable();
            $table->string("session_id");
            $table->string('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_entry');
    }
};
