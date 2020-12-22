<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    //
    protected $connection = 'mysql_products';

    protected $fillable = ['product_id','description'];

    public $timestamps = false;
    public function products()
    {
      return $this->belongsTo(Product::class);
    }
}
