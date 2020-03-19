<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{

    private $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /** login User
     *
     * @param LoginRequest $request
     * @return array|\Illuminate\Http\JsonResponse|string
     */
    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if($validated) {
            if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
                $this->user = Auth::user();
                if ($this->checkStatusUser()) {
                    $success['token'] =  $this->user->createToken('marketplace')->accessToken;
                    $success['nameFamily'] =  $this->user->name_family;
                    $success['remember_token'] =  $request->remember_me;
                    $success['role'] = $this->user->getRoleNames();
                    return $this->sendResponse($success, 'ورود موفقیت آمیز بود.');
                }
                return $this->sendError('حساب کاربری شما هنوز تایید نشده است.');
            }
            else{
                return $this->sendError('اطلاعات ورود صحیح نمی باشد.');
            }
        }
    }

    private function checkStatusUser()
    {
        if ($this->user->verify == 1) {
            return true;
        } else {
            return false;
        }
    }
}
