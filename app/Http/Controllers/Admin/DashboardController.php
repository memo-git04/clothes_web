<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Thêm dòng này để không bị lỗi Class "Redirect" not found

class DashboardController extends Controller
{
    /**
     * Hiển thị trang quản trị (Dashboard)
     */
    public function index()
    {
        return view('admin.layouts.dashboard');
    }

    /**
     * Hiển thị giao diện đăng nhập Admin
     */
    public function login ()
    {
        // Nếu admin đã đăng nhập từ trước, tự động chuyển hướng thẳng vào dashboard
        if (Auth::guard('admin')->check()) {
            return Redirect::route('dashboard');
        }
        
        return view('admin.layouts.login.page-login');
    }

    /**
     * Xử lý logic đăng nhập Admin
     */
    public function loginProcess(Request $request)
    {
        // Validate dữ liệu đầu vào cơ bản
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Vui lòng nhập Email.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
        ]);

        // Thử đăng nhập bằng Guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            
            $admin = Auth::guard('admin')->user();

            /**
             * Kiểm tra dựa trên cột role_id thực tế trong DB
             * Nếu role_id khác 1 (tức là không phải Admin) thì lập tức tống cổ ra ngoài.
             */
            if (!isset($admin->role_id) || $admin->role_id != 1) {
                Auth::guard('admin')->logout();
                 
                // ĐÃ SỬA: Xóa bỏ ->onlyInput('email') ở đây
                return redirect()->back()->withErrors([
                    'adminError' => 'Thông tin đăng nhập tài khoản không chính xác.'
                ]);
            }

            // Làm mới session để chống tấn công giả mạo (Session Fixation)
            $request->session()->regenerate();

            // Lưu thông tin admin vào session giống như code cũ của bạn
            session(['admin' => $admin]);

            // Chuyển hướng về trang Dashboard chính
            return Redirect::route('dashboard')->with('success', 'Đăng nhập thành công!');
        }

    
        return redirect()->back()->withErrors([
            'adminError' => 'Thông tin đăng nhập tài khoản không chính xác.'
        ]);
    }

    /**
     * Xử lý đăng xuất Admin
     */
    public function logout(Request $request)
    {
        // Đăng xuất khỏi Guard admin
        Auth::guard('admin')->logout();
        
        // Xóa session liên quan tới admin
        session()->forget('admin');
        
        // Hủy bỏ session hiện tại và làm mới token bảo mật
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Quay lại trang đăng nhập của Admin
        return Redirect::route('admin.login');
    }
}