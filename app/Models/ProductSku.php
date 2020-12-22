<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    //
    protected $connection = 'mysql_products';
    protected $fillable = [
      'title', 'price', 'stock', 'product_id','status',
      'parameter'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productskudescriptions()
    {
      return $this->hasOne(ProductSkuDescription::class,'product_sku_id','id');
    }
}
