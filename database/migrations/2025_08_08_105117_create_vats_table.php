<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('vats', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->string('vat_number')->unique();
        $table->decimal('percentage', 5, 2); // max 999.99% (adjust as needed)
        $table->boolean('status')->default(true); // active by default
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vats');
    }

};
