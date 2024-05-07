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
        Schema::create('dsrstocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string("invoice_no");
            $table->string("staff_id");
            $table->double("carton",11,2)->nullable();
            $table->double("piece",11,2)->nullable();
            $table->double("qty",11,2)->nullable();
            $table->double("purchase_return",11,2)->nullable();
            $table->double("sales_return",11,2)->nullable();
            $table->double("returncarton",11,2)->nullable();
            $table->double("returnpiece",11,2)->nullable();
            $table->double("returnqty",11,2)->nullable();
            $table->double("free",11,2)->nullable();
            $table->double("damage",11,2)->nullable();
            $table->double("purchase_price",11,2)->nullable();
            $table->double("sales_price",11,2)->nullable();
            $table->string('admin_id')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
