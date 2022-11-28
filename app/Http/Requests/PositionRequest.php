<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PositionRequest extends FormRequest
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
            'title' => ['required', Rule::unique('positions')->where(function($query){
                $query->where('title', $this->title)->where('id', '!=', $this->id);
            })]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Lavozim nomi kiritilmadi',
            'title.unique' => 'Lavozim allaqachon mavjud'
        ];
    }
}
