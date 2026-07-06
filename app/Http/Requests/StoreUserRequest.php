<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, |array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('users', 'user_name')->whereNull('deleted_at')
            ],
            'full_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\pL\s\-]+$/u' // Allows letters, spaces, and hyphens
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->whereNull('deleted_at')
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'confirmed'
            ],
            'password_confirmation' => 'required',
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]{10,11}$/',
                Rule::unique('users', 'phone')->whereNull('deleted_at')
            ],
            'gender' => [
                'required',
                'string',
                'in:male,female'
            ],
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01'
            ],
            'address' => [
                'required',
                'string',
                'max:255'
            ],

        ];
    }
    public function messages(): array
    {
        return [
            'user_name.required' => 'Tên đăng nhập là bắt buộc',
            'user_name.string' => 'Tên đăng nhập phải là chuỗi ký tự',
            'user_name.max' => 'Tên đăng nhập không được vượt quá 100 ký tự',
            'user_name.unique' => 'Tên đăng nhập đã tồn tại',

            'full_name.required' => 'Họ và tên là bắt buộc',
            'full_name.string' => 'Họ và tên phải là chuỗi ký tự',
            'full_name.max' => 'Họ và tên không được vượt quá 100 ký tự',
            'full_name.regex' => 'Họ và tên không chứa ký tự đặc biệt',

            'email.required' => 'Email là bắt buộc',
            'email.string' => 'Email phải là chuỗi ký tự',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.max' => 'Email không được vượt quá 100 ký tự',
            'email.unique' => 'Email đã tồn tại',

            'password.required' => 'Mật khẩu là bắt buộc',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',

            'phone.required' => 'Số điện thoại là bắt buộc',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự',
            'phone.regex' => 'Số điện thoại không hợp lệ (10-11 số)',
            'phone.unique' => 'Số điện thoại đã tồn tại',

            'gender.required' => 'Giới tính là bắt buộc',
            'gender.string' => 'Giới tính phải là chuỗi ký tự',
            'gender.in' => 'Giới tính không hợp lệ',

            'date_of_birth.required' => 'Ngày sinh là bắt buộc',
            'date_of_birth.date' => 'Định dạng ngày không hợp lệ',
            'date_of_birth.before' => 'Ngày sinh không hợp lệ',
            'date_of_birth.after' => 'Ngày sinh không hợp lệ',

            'address.required' => 'Địa chỉ là bắt buộc',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',

        ];
    }
}
