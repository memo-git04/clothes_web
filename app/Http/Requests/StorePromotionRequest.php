<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StorePromotionRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('promotions', 'code')->whereNull('deleted_at')
            ],
            'promotion_name' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => 'nullable|string|max:1000',
            'discount_value' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    $value = (int)str_replace(',', '', $value);
                    if ($value >= request()->min_order_amount) {
                        $fail('Giá trị giảm giá phải nhỏ hơn số tiền tối thiểu');
                    }
                }
            ],
            'min_order_amount' => [
                'required',
                'integer',
                'min:0',
                'gt:discount_value'
            ],
            'usage_limit' => [
                'required',
                'integer',
                'min:1'
            ],
            'start_date' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) {
                    $startDate = Carbon::parse($value);
                    if ($startDate->isPast()) {
                        $fail('Ngày bắt đầu không được là ngày trong quá khứ');
                    }
                    if ($startDate->greaterThan(Carbon::parse(request()->end_date))) {
                        $fail('Ngày bắt đầu phải trước ngày kết thúc');
                    }
                }
            ],
            'end_date' => [
                'required',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) {
                    $endDate = Carbon::parse($value);
                    if ($endDate->isPast()) {
                        $fail('Ngày kết thúc không được là ngày trong quá khứ');
                    }
                    if ($endDate->lessThanOrEqualTo(Carbon::parse(request()->start_date))) {
                        $fail('Ngày kết thúc phải sau ngày bắt đầu');
                    }
                }
            ]
        ];
    }
    public function messages()
    {
        return [
            'code.required' => 'Mã khuyến mãi là bắt buộc',
            'code.string' => 'Mã khuyến mãi phải là chuỗi ký tự',
            'code.max' => 'Mã khuyến mãi không được vượt quá 50 ký tự',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',

            'promotion_name.required' => 'Tên khuyến mãi là bắt buộc',
            'promotion_name.string' => 'Tên khuyến mãi phải là chuỗi ký tự',
            'promotion_name.max' => 'Tên khuyến mãi không được vượt quá 255 ký tự',

            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự',

            'discount_value.required' => 'Giá trị giảm giá là bắt buộc',
            'discount_value.integer' => 'Giá trị giảm giá phải là số nguyên',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0',

            'min_order_amount.required' => 'Số tiền tối thiểu là bắt buộc',
            'min_order_amount.integer' => 'Số tiền tối thiểu phải là số nguyên',
            'min_order_amount.min' => 'Số tiền tối thiểu không được nhỏ hơn 0',
            'min_order_amount.gt' => 'Số tiền tối thiểu phải lớn hơn giá trị giảm giá',

            'usage_limit.required' => 'Giới hạn sử dụng là bắt buộc',
            'usage_limit.integer' => 'Giới hạn sử dụng phải là số nguyên',
            'usage_limit.min' => 'Giới hạn sử dụng không được nhỏ hơn 1',

            'start_date.required' => 'Ngày bắt đầu là bắt buộc',
            'start_date.date_format' => 'Định dạng ngày giờ không hợp lệ',

            'end_date.required' => 'Ngày kết thúc là bắt buộc',
            'end_date.date_format' => 'Định dạng ngày giờ không hợp lệ'
        ];
    }
    protected function prepareForValidation()
    {
        // Format money fields by removing non-numeric characters
        $this->merge([
            'discount_value' => (int)str_replace(',', '', $this->discount_value),
            'min_order_amount' => (int)str_replace(',', '', $this->min_order_amount),
        ]);

        // Format datetime fields
        if ($this->start_date) {
            $this->merge([
                'start_date' => Carbon::parse($this->start_date)->format('Y-m-d H:i:s')
            ]);
        }

        if ($this->end_date) {
            $this->merge([
                'end_date' => Carbon::parse($this->end_date)->format('Y-m-d H:i:s')
            ]);
        }
    }
}
