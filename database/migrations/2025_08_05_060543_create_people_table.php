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
        Schema::create('people', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

        $table->string('name');
        $table->string('email')->nullable();
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        $table->string('country')->nullable();
        $table->string('city')->nullable();
        $table->string('bin_number')->nullable();

        $table->enum('person_type', ['customer', 'supplier', 'employee', 'other']);
        $table->boolean('status')->default(1);

        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
