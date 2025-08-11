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
    Schema::create('vat_group_vat', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vat_group_id')->constrained('vat_groups')->onDelete('cascade');
        $table->foreignId('vat_id')->constrained('vats')->onDelete('cascade');
        $table->timestamps();

        $table->unique(['vat_group_id', 'vat_id']); // prevent duplicate entries
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vat_group_vat');
    }
};
