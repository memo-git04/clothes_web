<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Mail\OtpMail;

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

        $request->validate([
            'user_name' => 'required|string|unique:users,user_name|max:100',
            'full_name' => 'required|string|max:100',
            'password' => 'required|min:8|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
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
                'user_name'     => $request->user_name,
                'full_name'     => $request->full_name,
                'email'         => $pending['email'],
                'phone'         => $pending['phone'],
                'password'      => Hash::make($request->password),
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'address'       => $request->address,
                'email_verified_at' => now(),     // Vì đã verify OTP
                'status'        => 'active',
            ]);
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
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($request->only('email', 'password', 'phone'))) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user->status !== 'active') {
                \Illuminate\Support\Facades\Auth::logout();
                return redirect()
                    ->route('login')
                    ->with('error', 'Tài khoản của bạn đã bị khóa.');
            }
            return redirect()
                ->route('home')
                ->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->route('login')->with('error', 'Email hoặc mật khẩu không đúng.');
    }
    public function logoutCustomer(){
        \Illuminate\Support\Facades\Auth::logout();
        session()->forget('cart'); // Xóa giỏ hàng khỏi session khi đăng xuất
        return redirect()->route('home');
    }
}
