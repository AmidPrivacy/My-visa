<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|email:rfc|unique:users,email',
            'username' => 'required|unique:users,username',
            'number' => 'required|min:5',
            'name' => 'required|min:3',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ];
    }
}