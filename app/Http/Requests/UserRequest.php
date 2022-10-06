<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'full_name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'position_id' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Foydalanuvchi F.I.O si kiritilmadi',
            'username.required' => 'Login kiritilmadi',
            'username.unique' => 'Login ni qiyinroq yarating',
            'password.required' => 'Parol kiritilmadi',
            'position_id.required' => 'Lavozim tanlanmadi'
        ];
    }
}
