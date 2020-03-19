<?php

namespace App\Http\Controllers\Api\v1;

use App\Coordinate;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegisterController extends BaseController
{
    /**
     * register User
     *
     * @param RegisterRequest $request
     * @return array
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        if ($validated) {

            DB::beginTransaction();

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            try {

                $user = new User();
                $user->email = $request->email;
                $user->name = $request->name;
                $user->family = $request->family;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->address = $request->address;
                $user->latitude = $request->latitude;
                $user->longitude = $request->longitude;
                $user->save();

            } catch (ValidationException $e) {
                DB::rollback();
                return $this->sendError('خطایی رخ داده است. لطفا مجددا ارسال نمایید.');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

//            try {
//
//                $coord = new Coordinate([
//                    'address' => $request->address,
//                    'latitude' => $request->latitude,
//                    'longitude' => $request->longitude,
//                ]);
//                $user->coordinates()->save($coord);
//
//            } catch(ValidationException $e)
//            {
//                DB::rollback();
//                return $this->sendError('خطایی رخ داده است. لطفا مجددا ارسال نمایید.');
//            } catch(\Exception $e)
//            {
//                DB::rollback();
//                throw $e;
//            }

            $success['token'] = $user->createToken('marketplace')->accessToken;
            $success['email'] = $user->email;
            $success['nameFamily'] = $user->name_family;
            $user->assignRole('customer');

            $success['role'] = $user->getRoleNames();
            DB::commit();

            return $this->sendResponse($success, 'ثبت نام با موفقیت انجام شد.');
        }
    }
}
