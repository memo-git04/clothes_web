<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'material_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('materials', 'material_name')->ignore($this->material->id)
            ]
        ];
    }
    public function messages()
    {
        return [
            'material_name.required' => "Tên chất liệu không được để trống",
            'material_name.string' => "Tên chất liệu phải là chuỗi",
            'material_name.max' => "Tên chất liệu không được vượt quá 255 ký tự",
            'material_name.unique' => 'Tên chất liệu đã tồn tại, vui lòng chọn tên khác.'
        ];
    }
}
