<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
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
            'color_name' => 'required|string|max:255|unique:colors,color_name',
        ];
    }

    public function messages()
    {
        return [
            'color_name.required' => "Tên màu không được để trống",
            'color_name.string' => "Tên màu phải là chuỗi",
            'color_name.max' => "Tên màu không được vượt quá 255 ký tự",
            'color_name.unique' => 'Tên màu đã tồn tại, vui lòng chọn tên khác.'
        ];
    }
}
