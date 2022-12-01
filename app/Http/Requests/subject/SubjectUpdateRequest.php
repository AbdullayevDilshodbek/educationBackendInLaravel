<?php

namespace App\Http\Requests\subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectUpdateRequest extends FormRequest
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
            'id' => 'required',
            'title' => ['required', Rule::unique('subjects')->where(function($query){
                $query->where('title', $this->title)->where('id', '!=', $this->id);
            })]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Fan nomi yuborilmadi',
            'title.unique' => 'Bu fan allaqachon mavjud'
        ];
    }
}
