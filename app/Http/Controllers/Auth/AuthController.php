<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $otp = rand(100000, 999999);
        $cacheKey = 'otp_' . $request->email;

        Cache::put($cacheKey, [
            'otp' => $otp,
            'phone' => $request->phone,
        ], now()->addMinutes(10));

        Mail::to($request->email)->send(new OtpMail($otp, $request->phone));

        return response()->json([
            'success' => true,
            'message' => 'Mã OTP đã được gửi đến email của bạn!',
            'email' => $request->email
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $cacheKey = 'otp_' . $request->email;
        $cached = Cache::get($cacheKey);

        if (!$cached || $cached['otp'] != $request->otp) {
            return response()->json(['error' => 'Mã OTP không đúng hoặc đã hết hạn'], 422);
        }

        session(['register_pending' => [
            'email' => $request->email,
            'phone' => $cached['phone']
        ]]);

        Cache::forget($cacheKey);

        return response()->json([
            'success' => true,
            'message' => 'Xác thực thành công!'
        ]);
    }

    public function showCompleteForm()
    {
        if (!session('register_pending')) {
            return redirect()->route('register')->with('error', 'Phiên đăng ký đã hết hạn.');
        }
        return view('auth.complete_register');
    }
    public function store(Request $request)
    {
        $pending = session('register_pending');

        if (!$pending) {
            return redirect()->route('register')->with('error', 'Phiên đăng ký không hợp lệ.');
        }

        $validated = $request->validate([
            'user_name' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_]+$/',
                'min:3',
                'max:100',
                Rule::unique('users', 'user_name')->whereNull('deleted_at')
            ],
            'full_name' => [
                'required',
                'string',
                'regex:/^[\pL\s\-]+$/u',
                'min:3',
                'max:100'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at')
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^0[0-9]{9,10}$/',
                'max:20',
                Rule::unique('users', 'phone')->whereNull('deleted_at')
            ],
            'address' => [
                'nullable',
                'string',
                'min:10',
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'confirmed'
            ],
            'password_confirmation' => 'string',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
        ], [
            // Custom error messages
            'user_name.required' => 'Tên người dùng không được để trống',
            'user_name.regex' => 'Tên người dùng chỉ chứa chữ cái, số và dấu gạch dưới',
            'user_name.unique' => 'Tên người dùng đã tồn tại',
            'full_name.required' => 'Họ và tên không được để trống',
            'full_name.regex' => 'Họ và tên chỉ chứa chữ cái và khoảng trắng',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'address.min' => 'Địa chỉ phải có ít nhất 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.regex' => 'Mật khẩu phải chứa chữ hoa, chữ thường, số và ký tự đặc biệt',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'date_of_birth.before' => 'Ngày sinh không hợp lệ'
        ]);

        try {
            if(User::where('email', $pending['email'])->exists()){
                Session::forget('register_pending');
                return redirect()->route('register')->with('error', 'Email đã tồn tại. Vui lòng sử dụng email khác.');
            }
            if (User::where('phone', $pending['phone'])->exists()) {
                Session::forget('register_pending');
                return redirect()->route('register')->with('error', 'Số điện thoại đã tồn tại. Vui lòng sử dụng số điện thoại khác.');
            }
            $user = User::create([
                'user_name' => $validated['user_name'],
                'full_name' => $validated['full_name'],
                'email' => $pending['email'],
                'phone' => $pending['phone'],
                'password' => Hash::make($validated['password']),
                'gender' => $validated['gender'],
                'date_of_birth' => $validated['date_of_birth'],
                'address' => $validated['address'],
                'email_verified_at' => now(),
                'status' => 'active',
            ]);
            $user->assignRole('customer');
            Session::forget('register_pending');
            return redirect()->route('login')
                ->with('success', 'Đăng ký tài khoản thành công! Vui lòng đăng nhập để tiếp tục.');
        }
       catch (\Exception $e){
            Log::error('Lỗi khi tạo tài khoản: ' . $e->getMessage());
            return redirect()->route('register')->with('error', 'Đã xảy ra lỗi khi tạo tài khoản. Vui lòng thử lại sau.');
       }
    }
    public function showCustomerLogin(){
        return view('auth.login');
    }
    public function customerLogin(Request $request){
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ]
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.regex' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải ít nhất 8 ký tự'
        ]);
        Auth::logout();
        if (\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password'))) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()
                    ->route('login')
                    ->with('error', 'Tài khoản của bạn đã bị khóa.');
            }
            $request->session()->regenerate();
            $request->session()->regenerateToken();
            if (!$user->hasRole('customer')) {
                return redirect()->route('loginAdmin');
            }
            return redirect()
                ->route('home')
                ->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->route('login')
            ->withInput($request->only('email'))
            ->with('error', 'Email hoặc mật khẩu không đúng.');
    }
    public function logoutCustomer(Request $request){
        \Illuminate\Support\Facades\Auth::logout();
//           $request->session()->invalidate();
//        session()->forget('cart');
        return redirect()->route('login');
    }
}
