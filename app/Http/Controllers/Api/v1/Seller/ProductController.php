<?php

namespace App\Http\Controllers\Api\V1\Seller;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
//use Facades\App\Repositories\Cache\ProductRepository;
use App\Http\Requests\Seller\ProductStoreRequest;
use App\Product;
use Facades\App\Repositories\Cache\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\ProductCollection
     */
    public function index()
    {
        $product = Product::where('user_id', Auth::user()->id)->paginate(5);
        return new \App\Http\Resources\ProductCollection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function store(ProductStoreRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {

            $product = new Product();
            $product->user_id = \auth()->user()->id;
            $product->seller_id = $request->shop_id;
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->save();

        } catch (ValidationException $e) {
            DB::rollback();
            return $this->sendError('خطایی رخ داده است. لطفا مجددا ارسال نمایید.');
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        return $this->sendResponse(null,'محصول با موفقیت ایجاد شد.');
    }
}
