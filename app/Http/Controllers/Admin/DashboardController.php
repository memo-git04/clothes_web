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
    public function login()
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
             * LƯU Ý QUAN TRỌNG: Kiểm tra phân quyền để chặn khách hàng.
             * Giả sử bảng users của bạn có cột 'role' (1 là Admin, 0 là Khách hàng).
             * Nếu không phải Admin thì logout ngay lập tức và báo lỗi.
             */
            if (isset($admin->role) && $admin->role !== 1) {
                Auth::guard('admin')->logout();
                return Redirect::back()->withErrors([
                    'adminError' => 'Tài khoản của bạn không có quyền truy cập trang Quản trị.'
                ])->onlyInput('email');
            }

            // Làm mới session để chống tấn công giả mạo (Session Fixation)
            $request->session()->regenerate();

            // Lưu thông tin admin vào session giống như code cũ của bạn (nếu cần dùng)
            session(['admin' => $admin]);

            // Chuyển hướng về trang Dashboard chính 
            // (Hoặc trỏ về 'admin.modules.brand.index_brand' tùy theo route của bạn)
            return Redirect::route('dashboard')->with('success', 'Đăng nhập thành công!');
        }

        // Đăng nhập thất bại: Quay lại trang cũ, hiển thị lỗi và giữ lại email vừa nhập
        return Redirect::back()->withErrors([
            'adminError' => 'Email hoặc mật khẩu Admin không chính xác.'
        ])->onlyInput('email');
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