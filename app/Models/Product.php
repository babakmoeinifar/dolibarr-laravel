<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'llx_product';

    protected $guarded = [];

    public function categoryProduct(){
        return $this->belongsTo(CategoryProduct::class,'rowid','fk_product');
    }

}
