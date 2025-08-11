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
    Schema::table('review_replies', function (Blueprint $table) {
        $table->foreignId('parent_id')->nullable()->constrained('review_replies')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_replies', function (Blueprint $table) {
            //
        });
    }
};
