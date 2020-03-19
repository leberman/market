<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email:rfc|max:255',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'لطفا فیلد ضروری را وارد نمایید.',
            'email' => 'آدرس ایمیل معتبر نمی باشد.',
        ];
    }
}
