<?php

namespace App\Http\Requests\Administrator;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class UserUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'family' => 'sometimes|string',
            'address' => 'sometimes|string',
            'latitude' => 'sometimes|string', // must integer and validate with regex
            'longitude' => 'sometimes|string', // must integer and validate with regex
            'verify' => 'sometimes|integer|in:0,1',
            'email' => 'sometimes|email|max:255|unique:users,email,'. request()->segment(5),
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|string|in:customer,seller,administrator',
        ];
    }
}
