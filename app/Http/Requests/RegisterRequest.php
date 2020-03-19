<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Api\BaseController;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'family' => 'required|string',
            'address' => 'required|string',
            'latitude' => 'required|string', // must integer and validate with regex
            'longitude' => 'required|string', // must integer and validate with regex
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ];
    }
}
