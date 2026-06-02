<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    // Hiển thị giao diện đăng nhập Khách hàng
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/');
        }
        return view('login'); // Tên file giao diện customer login (Tailwind) của bạn
    }

    // Xử lý đăng nhập Khách hàng
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
        ]);

        $remember = $request->has('remember');

        // Đăng nhập thông qua Guard 'web' mặc định của Khách hàng
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'customerError' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    // Đăng xuất Khách hàng
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}