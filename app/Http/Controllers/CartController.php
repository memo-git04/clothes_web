<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 

use Illuminate\Support\Facades\Auth; 
class CartController extends Controller
{
    public function index() {
        $cartItems = session()->get('cart', []);

    return view('cart', compact('cartItems'));
    }

    public function store(Request $request) {
        // 1. Lấy giỏ hàng từ session (nếu chưa có thì là mảng rỗng)
        $cart = session()->get('cart', []);

        // 2. Tạo ID duy nhất cho sản phẩm + size (để phân biệt)
        $id = $request->product_id . '_' . $request->size;

        // 3. Thêm hoặc cập nhật số lượng
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
    } else {
        $cart[$id] = [
            'product_id' => $request->product_id,
            'name'       => 'Tên sản phẩm', // Bạn nên lấy từ DB hoặc request
            'price'      => 245,           // Giá từ DB
            'size'       => $request->size,
            'quantity'   => $request->quantity
        ];
    }

    // 4. Lưu lại session
    session()->put('cart', $cart);

    // 5. Trả về JSON để menu cập nhật ngay lập tức
    return response()->json([
        'success' => true, 
        'newCount' => count($cart) // Số loại sản phẩm trong giỏ
    ]);
}
};