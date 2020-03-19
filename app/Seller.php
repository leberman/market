<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Seller extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'title', 'slug', 'description'
    ];

    /**
     * create slug for title En
     *
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 1);
    }

    public function coordinates()
    {
        return $this->hasMany(Coordinate::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class)->where('status', 1);
    }
}
