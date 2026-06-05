<?php
namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Cookie;
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
        $remember = $request->has('remember'); // Kiểm tra xem có tích remember me không
        if (Auth::guard('web')->attempt($credentials, $remember)) {
        
        // NẾU CÓ TÍCH CHỌN REMEMBER ME -> LƯU EMAIL VÀO COOKIE 1 NĂM
        if ($remember) {
            Cookie::queue('remember_customer_email', $request->email, 525600);
            Cookie::queue('remember_customer_password', $request->password, 525600);
        } else {
            // NẾU KHÔNG TÍCH -> XOÁ COOKIE CŨ ĐI
            Cookie::queue(Cookie::forget('remember_customer_email'));
            Cookie::queue(Cookie::forget('remember_customer_password'));
        }

        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => 2 
        ];
        if (Auth::attempt($credentials, $request->has('remember'))) {
        // Đăng nhập thành công, chuyển hướng về trang chủ khách hàng
            return redirect('/'); 
        }

    // 4. Thất bại thì trả về lỗi
    return redirect()->back()->withErrors([
        'customerError' => 'Thông tin đăng nhập tài khoản khách hàng không chính xác.'
    ]);
    }
    // Đăng xuất Khách hàng
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}