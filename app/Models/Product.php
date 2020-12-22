<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql_products';
    protected $table = 'products';

    protected $fillable = [
        'product_core', 'title', 'category_id', 'status',
        'audit_status', 'shop_id', 'description_id', 'rating',
        'sold_count','review_count','price','image'
    ];

    protected $casts = [
        'status' => 'boolean', // on_sale 是一个布尔类型的字段
    ];

    public function skus()
    {
      return $this->hasMany(ProductSku::class);
    }

    public function category()
    {
      return $this->belongsTo(Category::class);
    }

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }

    public function productdescriptions()
    {
      return $this->hasOne(ProductDescription::class);
    }
}
