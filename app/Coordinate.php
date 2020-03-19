<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coordinate extends Model
{
    use SoftDeletes;

    protected $table = 'seller_coordinates';

    protected $fillable = [
        'seller_id', 'latitude', 'longitude', 'address'
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
