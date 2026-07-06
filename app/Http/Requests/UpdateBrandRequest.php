<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'brand_name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,brand_name,',
                Rule::unique('brands', 'brand_name')->ignore($this->brand->id)
            ]
        ];
    }
    public function messages()
    {
        return [
            'brand_name.required' => "Tên thương hiệu không được để trống",
            'brand_name.string' => "Tên thương hiệu phải là chuỗi",
            'brand_name.max' => "Tên thương hiệu không được vượt quá 255 ký tự",
            'brand_name.unique' => 'Tên thương hiệu đã tồn tại, vui lòng chọn tên khác.'
        ];
    }
}
