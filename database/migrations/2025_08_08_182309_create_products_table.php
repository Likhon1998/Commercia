<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Product type: normal, combo, variant
            $table->enum('product_type', ['normal', 'combo', 'variant'])->default('normal');

            // Basic info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('model')->nullable();

            // Foreign keys
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('people')->nullOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();

            // Stock & pricing
            $table->integer('min_qty_alert')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->string('sku')->nullable()->unique();
            $table->decimal('discount_percent', 5, 2)->default(0);

            // VAT related
            $table->enum('vat_type', ['vat', 'group'])->nullable();
            $table->foreignId('vat_id')->nullable()->constrained('vats')->nullOnDelete();
            $table->decimal('vat_percent', 5, 2)->default(0);

            // Discount
            $table->enum('discount_type', ['percentage', 'amount'])->nullable();

            // Barcode
            $table->boolean('is_barcode')->default(false);
            $table->enum('barcode_source', ['generate', 'supplier'])->default('generate');

            // Image
            $table->string('image')->nullable();

            // Flags
            $table->boolean('is_warranty')->default(false);
            $table->boolean('is_salable')->default(true);
            $table->boolean('is_expirable')->default(false);
            $table->boolean('is_serviceable')->default(false);

            // HSN Code & website visibility
            $table->string('hsn_code')->nullable();
            $table->boolean('show_on_website')->default(false);

            // Expiry days
            $table->integer('near_expiry_days')->nullable();
            $table->integer('warning_expiry_days')->nullable();

            // Cost, margin & selling prices
            $table->decimal('cost_price_exc_vat', 15, 4)->default(0);
            $table->decimal('cost_price_inc_vat', 15, 4)->default(0);
            $table->decimal('margin_percent', 5, 2)->default(0);
            $table->decimal('selling_price_exc_vat', 15, 4)->default(0);
            $table->decimal('selling_price_inc_vat', 15, 4)->default(0);
            $table->decimal('profit_percent', 5, 2)->default(0);

            // Tags & descriptions
            $table->text('tags')->nullable(); // comma separated tags
            $table->longText('description')->nullable();
            $table->longText('additional_information')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
