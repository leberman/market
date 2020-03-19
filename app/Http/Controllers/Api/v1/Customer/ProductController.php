<?php

namespace App\Http\Controllers\Api\v1\Customer;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Api\v1\NearestController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CoordinateCollection;
use App\Http\Resources\Product;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SellerCollection;
use App\User;
use Facades\App\Repositories\Cache\ProductRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{

    public function index()
    {
        $nearest = new NearestController(\auth()->user()->latitude, \auth()->user()->longitude);
        $collectionCoordinate = $nearest->coordinate();

        if ($collectionCoordinate->count() > 0) {
            return new CoordinateCollection($collectionCoordinate);
        } else {
            return $this->sendError('فروشگاهی در محدوده شما یافت نشد.'); 
        }
    }
}
