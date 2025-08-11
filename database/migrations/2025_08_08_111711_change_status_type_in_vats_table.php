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
    Schema::table('vats', function (Blueprint $table) {
        $table->string('status')->default('active')->change();
    });
}

public function down()
{
    Schema::table('vats', function (Blueprint $table) {
        $table->integer('status')->default(1)->change();
    });
}

};
