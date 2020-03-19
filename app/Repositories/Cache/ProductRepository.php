<?php

namespace App\Repositories\Cache;

//use Your Model
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class Product.
 */
class ProductRepository
{
    CONST CACHE_KEY = 'PRODUCT';

    /**
     * get all Products
     *
     * @return mixed|string
     */
    public function all()
    {
        $key = "all";
        $cacheKey = $this->getCacheKey($key);
        try {
            return cache()->remember($cacheKey, Carbon::now()->addMinute(5), function () {
                return Product::published()->get();
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * find Product by id  from cache
     *
     * @param $id
     * @param array $select
     * @return mixed|string
     */
    public function find($id, array $select)
    {
        $key = "find.{$id}";
        $cacheKey = $this->getCacheKey($key);
        try {
            return cache()->remember($cacheKey, Carbon::now()->addDay(5), function () use ($select,$id) {
                return DB::table('products')->select($select)->where('id' , $id)->first();
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get Product by id  from cache
     *
     * @param $id
     * @return mixed|string
     */
    public function get($id)
    {
        $key = "get.{$id}";
        $cacheKey = $this->getCacheKey($key);
        try {
            return Product::find($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * create cache key
     *
     * @param $key
     * @return string
     */
    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }

}
