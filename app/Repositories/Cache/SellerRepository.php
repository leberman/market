<?php

namespace App\Repositories\Cache;

use App\Seller;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class Seller.
 */
class SellerRepository
{
    CONST CACHE_KEY = 'SELLER';

    /**
     * get all Sellers
     *
     * @return mixed|string
     */
    public function all()
    {
        $key = "all";
        $cacheKey = $this->getCacheKey($key);
        try {
            return cache()->remember($cacheKey, Carbon::now()->addMinute(5), function () {
                return Seller::paginate(5);
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * find Seller by id  from cache
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
                return DB::table('sellers')->select($select)->where('id' , $id)->first();
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get User by id  from cache
     *
     * @param $id
     * @return mixed|string
     */
    public function get($id)
    {
        $key = "get.{$id}";
        $cacheKey = $this->getCacheKey($key);
        try {
            return Seller::find($id);
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
