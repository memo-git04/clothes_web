<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'product_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'product_name')->ignore($this->product->id)->whereNull('deleted_at')
            ],
            'description' => 'nullable|string',

            // Variants validation
            'variants' => 'required|array',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.base_price' => 'required|min:0',
            'variants.*.selling_price' => 'required|min:0|gte:variants.*.base_price',

            // Images validation
            'variants.*.images' => 'nullable|array',
            'variants.*.images.*' => 'image|max:2048',
        ];
    }
    public function messages(): array
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc',
            'product_name.string' => 'Tên sản phẩm phải là chuỗi ký tự',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự',
            'product_name.unique' => 'Tên sản phẩm đã tồn tại',
            'description.string' => 'Mô tả phải là chuỗi ký tự',


            'variants.required' => 'Phải có ít nhất một biến thể sản phẩm',
            'variants.*.stock_quantity.required' => 'Số lượng là bắt buộc',
            'variants.*.stock_quantity.integer' => 'Số lượng phải là số nguyên',
            'variants.*.stock_quantity.min' => 'Số lượng không được nhỏ hơn 0',
            'variants.*.base_price.required' => 'Giá gốc là bắt buộc',
            'variants.*.base_price.min' => 'Giá gốc không được nhỏ hơn 0',
            'variants.*.selling_price.required' => 'Giá bán là bắt buộc',
            'variants.*.selling_price.min' => 'Giá bán không được nhỏ hơn 0',
            'variants.*.selling_price.gte' => 'Giá bán không được nhỏ hơn giá gốc',

            // Images messages
            'variants.*.images.*.image' => 'Tệp phải là hình ảnh',
//            'variants.*.images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'variants.*.images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',

        ];
    }
}
