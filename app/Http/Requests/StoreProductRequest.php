<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
                Rule::unique('products', 'product_name')->whereNull('deleted_at')
            ],
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'material_id' => 'required|exists:materials,id',
            'brand_id' => 'required|exists:brands,id',
            //variant
            'variants' => 'required|array',
            'variants.*.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.*.base_price' => 'required|min:0',
            'variants.*.*.selling_price' => 'required|min:0|gte:variants.*.*.base_price',
            //image
            'color_images' => 'required|array',
            'color_images.*' => 'array',
            'color_images.*.*' => 'image|max:2048'
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
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không tồn tại',
            'material_id.required' => 'Vui lòng chọn chất liệu',
            'material_id.exists' => 'Chất liệu không tồn tại',
            'brand_id.required' => 'Vui lòng chọn thương hiệu',
            'brand_id.exists' => 'Thương hiệu không tồn tại',
            //variant
            'variants.required' => 'Biến thể sản phẩm không được để trống',
            'variants.*.*.stock_quantity.required' => 'Số lượng không được để trống',
            'variants.*.*.stock_quantity.integer' => 'Số lượng phải là số nguyên',
            'variants.*.*.stock_quantity.min' => 'Số lượng không được nhỏ hơn 0',

            'variants.*.*.base_price.required' => 'Giá gốc không được để trống',
            'variants.*.*.base_price.min' => 'Giá gốc không được nhỏ hơn 0',
            'variants.*.*.selling_price.required' => 'Giá bán không được để trống',
            'variants.*.*.selling_price.min' => 'Giá bán không được nhỏ hơn 0',
            'variants.*.*.selling_price.gte' => 'Giá bán không được nhỏ hơn giá gốc',
            //image
            'color_images.required' => 'Phải có ít nhất một hình ảnh sản phẩm',
            'color_images.*.*.image' => 'Tệp phải là hình ảnh',
//            'color_images.*.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'color_images.*.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB'
        ];
    }
}
