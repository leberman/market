<?php

namespace App\Http\Controllers\Api\v1\Administrator;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\CustomerStoreRequest;
use App\Http\Requests\Administrator\UserUpdateRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\User;
use App\Http\Resources\UserCollection;
use Facades\App\Repositories\Cache\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $user = UserRepository::all();
        return new UserCollection($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     * @return User
     */
    public function show($id)
    {
        $user = UserRepository::get($id);
        return (! empty($user) ?  new User($user) :  $this->sendError('کاربر یافت نشد.'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return array
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $request->validated();
        $user = \App\User::where('id', $id)->first();
        if(!empty($user)){

            $user->name = $request->name;
            $user->family = $request->family;
            $user->address = $request->address;
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->email = $request->email;
            $user->verify = $request->verify;

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            }

            $user->update();
            Cache::forget("USER.GET.{$id}");

            return $this->sendResponse(null, 'کاربر با موفقیت ویرایش شد.');

        } else {
            return $this->sendError('کاربر یافت نشد.');
        }
    }

}
