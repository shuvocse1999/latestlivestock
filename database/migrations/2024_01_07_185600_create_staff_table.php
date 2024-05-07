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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string("staff_name");
            $table->string("designation")->nullable();
            $table->string("nid")->nullable();
            $table->string("phone")->nullable();
            $table->string("father_name")->nullable();
            $table->string("mother_name")->nullable();
            $table->text("joining_date")->nullable();
            $table->text("address")->nullable();
            $table->double("salary",11,2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
