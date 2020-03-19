<?php

namespace App\Http\Controllers\Api\v1\Administrator;

use App\Coordinate;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\CustomerStoreRequest;
use App\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CustomerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function store(CustomerStoreRequest $request)
    {
        $validated = $request->validated();

        $user = User::find($request->user_id);

        if ($validated) {
            DB::beginTransaction();
            try {

                $seller = new Seller();
                $seller->user_id = $request->user_id;
                $seller->title = $request->title;
                $seller->slug = $request->slug;
                $seller->description = $request->description;
                $seller->save();

            } catch (ValidationException $e) {
                DB::rollback();
                return $this->sendError('خطایی رخ داده است. لطفا مجددا ارسال نمایید.');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }


            try {

                $coordinate = new Coordinate([
                    'address' => $request->address,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
                $seller->coordinates()->save($coordinate);

            } catch(ValidationException $e)
            {
                DB::rollback();
                return $this->sendError('خطایی رخ داده است. لطفا مجددا ارسال نمایید.');
            } catch(\Exception $e)
            {
                DB::rollback();
                throw $e;
            }

            DB::commit();

            $user->syncRoles('seller');

            return $this->sendResponse(null,'فروشگاه با موفقیت ایجاد شد.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
