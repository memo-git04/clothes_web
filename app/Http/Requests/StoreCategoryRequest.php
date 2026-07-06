<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;
        return [
            'category_name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,category_name,NULL,id,deleted_at,NULL'
            ],
            'description' => 'nullable|string|max:255',
            'parent_ids' => 'nullable|array',
            'parent_ids.*' => 'exists:categories,id,deleted_at,NULL'
        ];
    }
    public function messages(): array
    {
        return [
            'category_name.required' => 'Tên danh mục không được để trống.',
            'category_name.string' => 'Tên danh mục phải là chuỗi.',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'category_name.unique' => 'Tên danh mục đã tồn tại.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'parent_ids.array' => 'Danh mục cha phải là một mảng.',
            'parent_ids.*.exists' => 'Danh mục cha không tồn tại.',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $categoryId = $this->route('category') ? $this->route('category')->id : null;
            $parentIds = $this->input('parent_ids', []);

            if ($categoryId && !empty($parentIds) && in_array($categoryId, $parentIds)) {
                $validator->errors()->add('parent_ids', 'Danh mục không thể là danh mục cha của chính mình.');
            }

            // Check if selected parents are at the correct level (max 3 levels)
            if (!empty($parentIds)) {
                $maxParentLevel = \App\Models\Category::whereIn('id', $parentIds)->max('level');
                if ($maxParentLevel >= 2) { // +1 for the new category would make it 3
                    $validator->errors()->add('parent_ids', 'Danh mục con chỉ được phép có tối đa 3 cấp.');
                }
            }
        });
    }
}
