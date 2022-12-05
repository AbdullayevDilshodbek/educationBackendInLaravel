<?php

namespace App\Http\Requests\rule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRuleRequest extends FormRequest
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
            'title' => ['required', Rule::unique('rules')->where(function($query){
                $query->where('title', $this->title)->where('id', '!=', $this->id);
            })],
            'rule_model_id' => 'required',
            'key' => ['required', Rule::unique('rules')->where(function($query){
                $query->where('key', $this->key)->where('id', '!=', $this->id);
            })]
        ];
    }
}
