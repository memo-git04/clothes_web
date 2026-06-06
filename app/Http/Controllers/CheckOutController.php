<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
    // Lấy giỏ hàng từ session để hiển thị ở cột bên phải
        $cartItems = session()->get('cart', []);
    
    // Kiểm tra nếu giỏ hàng trống thì quay về trang cart
        if (empty($cartItems)) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
    }

    return view('checkout', compact('cartItems'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name' => 'required',
            'receiver_phone' => 'required',
            'detailed_address' => 'required',
        ]);

        // 1. Lấy giỏ hàng từ Session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->withErrors(['error' => 'Giỏ hàng của bạn đang trống.']);
        }

        DB::beginTransaction();
        try {
            // 2. Tính tổng tiền từ mảng Session
            $totalAmount = array_reduce($cart, function ($sum, $item) {
                return $sum + ($item['quantity'] * $item['price']);
            }, 0);

            // 3. Tạo đơn hàng (Order)
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'ORD-' . strtoupper(uniqid()),
                'status_id' => 1,
                'total_amount' => $totalAmount,
                'final_amount' => $totalAmount,
            ]);

            // 4. Tạo địa chỉ nhận hàng
            OrderAddress::create([
                'order_id' => $order->id,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'detailed_address' => $request->detailed_address,
                // ... các trường khác
            ]);

            // 5. Lưu chi tiết sản phẩm (OrderItem)
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    // Lưu ý: Nếu trong session bạn chỉ lưu product_variant_id
                    'product_variant_id' => $item['product_variant_id'], 
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            // 6. Xóa giỏ hàng trong Session
            session()->forget('cart');

            DB::commit();
            return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
    }   
}