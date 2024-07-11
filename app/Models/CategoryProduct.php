<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    protected $table = 'llx_categorie_product';

    protected $guarded = [];

    public function category(){
        return $this->belongsTo(Category::class,'fk_categorie','rowid');
    }

    // public function product(){
    //     return $this->belongsTo(Product::class,'fk_product','rowid');
    // }
}
