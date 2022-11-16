<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizationRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('organizations')->where(function ($q) {
                    $q->where('title', $this->title)
                    ->where('id', '!=', $this->id);
                })
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tashkilot nomi kiritilmadi',
            'title.unique' => 'Tashkilot mavjud'
        ];
    }
}
