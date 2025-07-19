<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sku',
        'stock_qty',
        'category_id',
        'status',
    ];

    /**
     * Product belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A product has many images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * A product has one primary image (is_primary = true).
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Product attribute values relationship.
     * Adjust foreign keys if your pivot table columns differ.
     */
  public function attributeValues()
{
    return $this->belongsToMany(
        ProductAttributeValue::class,
        'product_attribute_product',
        'product_id',
        'product_attribute_value_id'
    );
}


    /**
     * Product attributes relationship.
     * Adjust foreign keys if your pivot table columns differ.
     */
public function attributes()
{
    return $this->hasManyThrough(
        ProductAttribute::class,
        ProductAttributeValue::class,
        'product_attribute_id', // Foreign key on attribute values table...
        'id',                   // Foreign key on attributes table...
        'id',                   // Local key on products table...
        'product_attribute_id'  // Local key on attribute values table...
    );
}
}
