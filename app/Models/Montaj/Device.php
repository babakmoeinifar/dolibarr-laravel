<?php

namespace App\Models\Montaj;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $guarded = ['id'];

    public function sales()
    {
        return $this->hasMany(\App\Models\Montaj\Sales::class, 'device_id');
    }
}
