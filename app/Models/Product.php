<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_type',
        'name',
        'slug',
        'model',
        'brand_id',
        'category_id',
        'sub_category_id',
        'supplier_id',
        'unit_id',
        'min_qty_alert',
        'price',
        'sku',
        'stock_qty',
        'discount_percent',
        'discount_type',
        'vat_type',
        'vat_id',
        'vat_percent',
        'is_barcode',
        'barcode_source',
        'image',
        'is_warranty',
        'is_salable',
        'is_expirable',
        'is_serviceable',
        'hsn_code',
        'show_on_website',
        'near_expiry_days',
        'warning_expiry_days',
        'cost_price_exc_vat',
        'cost_price_inc_vat',
        'margin_percent',
        'selling_price_exc_vat',
        'selling_price_inc_vat',
        'profit_percent',
        'tags',
        'description',
        'additional_information',
        'status',
    ];

    protected $casts = [
        'is_barcode' => 'boolean',
        'is_warranty' => 'boolean',
        'is_salable' => 'boolean',
        'is_expirable' => 'boolean',
        'is_serviceable' => 'boolean',
        'show_on_website' => 'boolean',
        'price' => 'float',
        'cost_price_exc_vat' => 'float',
        'cost_price_inc_vat' => 'float',
        'margin_percent' => 'float',
        'selling_price_exc_vat' => 'float',
        'selling_price_inc_vat' => 'float',
        'profit_percent' => 'float',
        'discount_percent' => 'float',
        'stock_qty' => 'integer',
        'min_qty_alert' => 'integer',
        'near_expiry_days' => 'integer',
        'warning_expiry_days' => 'integer',
        'status' => 'boolean',
    ];

    // Relations

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(People::class, 'supplier_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function vat()
    {
        return $this->belongsTo(Vat::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function attributeValues()
    {
        return $this->belongsToMany(
            ProductAttributeValue::class,
            'product_attribute_product',
            'product_id',
            'product_attribute_value_id'
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
