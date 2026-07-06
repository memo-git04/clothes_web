<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
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
            'size_name' => 'required|string|max:255|unique:sizes,size_name',
        ];
    }
    public function messages()
    {
        return [
            'size_name.required' => "Tên size không được để trống",
            'size_name.string' => "Tên size phải là chuỗi",
            'size_name.max' => "Tên size không được vượt quá 255 ký tự",
            'size_name.unique' => 'Tên size đã tồn tại, vui lòng chọn tên khác.'
        ];
    }
}
