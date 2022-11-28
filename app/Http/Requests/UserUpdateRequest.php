<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => ['required', Rule::unique('users')->where(
                function ($q) {
                    $q->where('username', $this->username)
                        ->where('id', '!=', $this->id);
                }
            )],
            'full_name' => 'required',
            'position' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Login kiritilmadi',
            'username.unique' => 'Login qiyinroq bo\'lishi lozim',
            'full_name.required' => 'Foydalanuvchi F.I.O si kiritilmadi',
            'position.required' => 'Lavozim tanlanmadi'
        ];
    }
}
