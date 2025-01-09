<?php

namespace App\Models\Montaj;

use Illuminate\Database\Eloquent\Model;
use App\Models\Montaj\Device;

class Sales extends Model
{
    protected $guarded = ['id'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
