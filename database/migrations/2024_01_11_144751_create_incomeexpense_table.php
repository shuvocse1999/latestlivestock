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
        Schema::create('incomeexpense', function (Blueprint $table) {
            $table->id();
            $table->string("dates");
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->double("amount",11,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomeexpense');
    }
};
