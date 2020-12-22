<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSkuDescription extends Model
{
    protected $connection = 'mysql_products';
    public $timestamps = false;
    protected $fillable = ['product_sku_id','description'];
    public function product_skus()
    {
      return $this->belongsTo(ProductSku::class);
    }
}
