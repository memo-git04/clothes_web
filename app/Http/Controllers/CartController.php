<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\Promotion;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        $variant = ProductVariant::with(['product', 'size', 'color', 'images'])
            ->findOrFail($variantId);
        //check if out of stock
        if ($variant->stock_quantity <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm hiện đang hết hàng!');
        }

        //check if quantity exceeds available stock
        $cart = session()->get('cart', []);
        $currentQuantityInCart = isset($cart[$variantId]) ? $cart[$variantId]['quantity'] : 0;

        if (($currentQuantityInCart + $quantity) > $variant->stock_quantity) {
            return redirect()->back()->with('error', 'Số lượng vượt quá số lượng tồn kho!');
        }

        $imageUrl = 'default.jpg';
        if ($variant->images->isNotEmpty()) {
            $mainImage = $variant->images->firstWhere('is_main', 1) ?? $variant->images->first();
            $imageUrl = $mainImage->image_url;
        }

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            $cart[$variantId] = [
                'name'       => $variant->product->product_name,
                'price'      => $variant->selling_price,
                'quantity'   => $quantity,
                'image'      => asset('storage/' . $imageUrl),
                // Lưu chuỗi thay vì object
                'size_name'  => isset($variant->size->size_name) ? $variant->size->size_name : 'N/A',
                'color_name' => isset($variant->color->color_name) ? $variant->color->color_name : 'N/A',
                //lấy ìd
                'size_id'    => $variant->size_id,
                'color_id'   => $variant->color_id,
            ];
        }
        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function index(){
        $cart = session()->get('cart', []);
        $cartItems = [];

        foreach ($cart as $id => $item) {
            $cartItems[] = array_merge(['id' => $id], $item);
        }
//        dd($cart);

        $availableCoupons = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        $selectedCoupon = null;

        if (session('selected_coupon')) {
            $selectedCoupon = Promotion::find(session('selected_coupon'));
        }

        return view('cart', [
            'cartItems'       => $cartItems,
            'availableCoupons'=> $availableCoupons,
            'selectedCoupon'  => $selectedCoupon,
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $id = $request->id;
        $quantity = (int) $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity < 1) {
                unset($cart[$id]);
            } else {
                $cart[$id]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function removeItem(Request $request)
    {
        $id = $request->id;
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.index');
    }

    public function checkout(){
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống!');
        }

        $cartItems = [];
        foreach ($cart as $id => $item) {
            $cartItems[] = array_merge(['id' => $id], $item);
        }

        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);

        // Lấy các mã giảm giá hợp lệ
        $availableCoupons = Promotion::where('is_active', 1)
            ->get();

        $selectedCoupon = null;
        if (session('selected_coupon')) {
            $selectedCoupon = Promotion::find(session('selected_coupon'));
        }
//        dd($availableCoupons->toArray(), $subtotal);

        return view('checkout',[
            'cartItems' => $cartItems,
            'user' => auth()->user(),
            'availableCoupons'=> $availableCoupons,
            'selectedCoupon'  => $selectedCoupon,
            'subtotal'        => $subtotal,

        ]);
    }
    public function buyNow(Request $request){
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        try {
            $variant = ProductVariant::with(['product', 'size', 'color', 'images'])
                ->findOrFail($variantId);

            // Check if out of stock
            if ($variant->stock_quantity <= 0) {
                return redirect()->back()->with('error', 'Sản phẩm hiện đang hết hàng!');
            }

            // Check if quantity exceeds available stock
            if ($quantity > $variant->stock_quantity) {
                return redirect()->back()->with('error', 'Số lượng vượt quá số lượng tồn kho!');
            }

            // Get image URL
            $imageUrl = 'default.jpg';
            if ($variant->images->isNotEmpty()) {
                $mainImage = $variant->images->firstWhere('is_main', 1) ?? $variant->images->first();
                $imageUrl = $mainImage->image_url;
            }

            // Create cart session with single item
            $cart = [
                $variantId => [
                    'name' => $variant->product->product_name,
                    'price' => $variant->selling_price,
                    'quantity' => $quantity,
                    'image' => asset('storage/' . $imageUrl),
                    'size_name' => $variant->size->size_name ?? 'N/A',
                    'color_name' => $variant->color->color_name ?? 'N/A',
                    'size_id' => $variant->size_id,
                    'color_id' => $variant->color_id,
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id
                ]
            ];

            // Set cart session
            session()->put('cart', $cart);

            // Redirect to checkout
            return redirect()->route('checkout');

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        } catch (Exception $e) {
            Log::error('Lỗi khi mua ngay: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi vui lòng thử lại!');
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'receiver_address' => 'required|string|max:255',
            'payment_method'   => 'required|in:cod,online',
        ]);
        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discount = 0;
        $promotionId = null;

        // Xử lý coupon
        if (session('selected_coupon')) {
            $coupon = Promotion::find(session('selected_coupon'));
            //VALIDATE  BEFORE APPLYING
            if ($coupon &&
                $coupon->is_active &&
                now()->between($coupon->start_date, $coupon->end_date) &&
                $subtotal >= $coupon->min_order_amount &&
                $coupon->current_usage < $coupon->usage_limit &&
                $this->canUsePromotion($coupon)){
                //tinh toán giảm giá
                $discount = $coupon->discount_value;
                $promotionId = $coupon->id;
            }else{
                // Nếu coupon không hợp lệ, xóa khỏi session
                session()->forget('selected_coupon');
            }
        }

        $final = $subtotal - $discount;
        $method = $request->payment_method; // 'cod' | 'online'

        try {
            // Tạo đơn (kèm order items + trừ kho + payment) trong 1 transaction
            // Áp dụng cho CẢ COD LẪN ONLINE => đơn online luôn được lưu vào DB.
            $order = DB::transaction(function () use ($cartItems, $subtotal, $discount, $final, $promotionId, $request, $method) {
                $order = Order::create([
                    'user_id'          => auth()->id(),
                    'order_code'       => 'ORD' . time() . rand(100, 999),
                    'promotion_id'     => $promotionId,
                    'status_id'        => Order::STATUS_PENDING,
                    'total_amount'     => $subtotal,
                    'discount_amount'  => $discount,
                    'final_amount'     => $final,
                    'receiver_name'    => $request->receiver_name,
                    'receiver_phone'   => $request->receiver_phone,
                    'receiver_address' => $request->receiver_address,
                ]);

                foreach ($cartItems as $variantId => $item) {
                    $variant = ProductVariant::lockForUpdate()->findOrFail($variantId);

                    if ($variant->stock_quantity < $item['quantity']) {
                        throw new \RuntimeException(
                            'Sản phẩm "' . ($item['name'] ?? '') . '" không đủ tồn kho.'
                        );
                    }

                    OrderItem::create([
                        'order_id'           => $order->id,
                        'product_variant_id' => $variantId,
                        'price'              => $item['price'],
                        'quantity'           => $item['quantity'],
                    ]);

                    $variant->decrement('stock_quantity', $item['quantity']);
                }

                // Tăng lượt dùng mã giảm giá (nếu có)
                if ($promotionId) {
                    Promotion::where('id', $promotionId)->increment('current_usage');
                }

                // 1 payment cho cả đơn (không tạo theo từng item nữa)
                Payment::create([
                    'order_id' => $order->id,
                    'method'   => $method,
                    'status'   => 'pending', // COD & online đều chờ; online sẽ đổi ở callback
                    'txn_ref'  => $order->order_code,
                    'amount'   => $final,
                ]);
                return $order;
            });
        } catch (\Exception $e) {
            return redirect()->route('checkout')
                ->with('error', 'Đặt hàng thất bại: ' . $e->getMessage());
        }

        // COD: xong luôn
        if ($method === 'cod') {
            session()->forget(['cart', 'selected_coupon']);
            return redirect()->route('orderHistory')
                ->with('success', 'Đặt hàng thành công! Mã đơn: ' . $order->order_code);
        }

        // ONLINE: đơn đã lưu (pending) -> chuyển sang VNPay
        session()->forget(['cart', 'selected_coupon']);
        return redirect($this->buildVnpayUrl($order, $final));
    }

    /**
     * Tạo URL thanh toán VNPay cho 1 đơn đã được lưu.
     * Dùng order_code làm vnp_TxnRef để tra cứu lại khi callback.
     */
    private function buildVnpayUrl(Order $order, float $amount): string
    {
        $vnp_TmnCode    = env('VNP_TMNCODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url        = env('VNP_URL');
        $vnp_Returnurl  = env('VNP_RETURNURL', url('/payment-return'));

        $inputData = [
            "vnp_Version"   => "2.1.0",
            "vnp_TmnCode"   => $vnp_TmnCode,
            "vnp_Amount"    => (int) round($amount * 100),
            "vnp_Command"   => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"  => "VND",
            "vnp_IpAddr"    => request()->ip(),
            "vnp_Locale"    => "vn",
            "vnp_OrderInfo" => "Thanh toan don hang " . $order->order_code,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef"    => $order->order_code,
        ];

        ksort($inputData);
        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return $vnp_Url;
    }

    /**
     * VNPay callback (return URL): xác thực chữ ký và cập nhật trạng thái thanh toán.
     */
    public function paymentReturn(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $inputData = [];
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) === "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';
        unset($inputData['vnp_SecureHash'], $inputData['vnp_SecureHashType']);
        ksort($inputData);

        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $order = Order::where('order_code', $request->input('vnp_TxnRef'))->first();
        $valid = hash_equals($secureHash, $vnp_SecureHash);
        $success = $valid && $request->input('vnp_ResponseCode') === '00';

        if ($order) {
            $payment = $order->payment;
            if ($payment && $payment->status === 'pending') {
                if ($success) {
                    $payment->update([
                        'status'         => 'paid',
                        'transaction_no' => $request->input('vnp_TransactionNo'),
                        'paid_at'        => now(),
                    ]);
                } else {
                    // Thanh toán thất bại: hủy đơn + hoàn kho
                    $payment->update(['status' => 'failed']);
                    DB::transaction(function () use ($order) {
                        foreach ($order->orderItems as $item) {
                            ProductVariant::where('id', $item->product_variant_id)
                                ->increment('stock_quantity', $item->quantity);
                        }
                        if ($order->promotion_id) {
                            Promotion::where('id', $order->promotion_id)
                                ->where('current_usage', '>', 0)
                                ->decrement('current_usage');
                        }
                        $order->update(['status_id' => Order::STATUS_CANCELLED]);
                    });
                }
            }
        }
//        session()->regenerate(true);

        return view('payment_return', [
            'success' => $success,
            'order'   => $order,
        ]);
    }
    //check ma
    private function canUsePromotion($promotion)
    {
        if ($promotion->current_usage >= $promotion->usage_limit) {
            return false;
        }

        // Kiểm tra user đã dùng chưa
        $used = Order::where('user_id', auth()->id())
            ->where('promotion_id', $promotion->id)
            ->count();
        if ($used >= $promotion->per_user_limit) {
            return false;
        }
        return true;
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|integer'
        ]);

        $couponId = $request->coupon_id;
        $cartItems = session()->get('cart', []);
        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);

        // If "Không dùng mã" is selected
        if ($couponId == 0) {
            session()->forget('selected_coupon');
            return redirect()->route('checkout')->with('success', 'Đã bỏ mã giảm giá');
        }

        // Find the coupon
        $coupon = Promotion::find($couponId);

        if (!$coupon) {
            session()->forget('selected_coupon');
            return redirect()->route('checkout')->with('error', 'Mã giảm giá không tồn tại');
        }

        // Validate coupon
        if (!$coupon->is_active) {
            return redirect()->route('checkout')->with('error', 'Mã giảm giá không còn hiệu lực');
        }


        if (!now()->between($coupon->start_date, $coupon->end_date)) {
            $now = Carbon::now();
            if ($now->lt($coupon->start_date)) {
                return redirect()->route('checkout')->with('error', 'Mã giảm giá chưa đến thời gian áp dụng');
            } else {
                return redirect()->route('checkout')->with('error', 'Mã giảm giá đã hết thời gian sử dụng');
            }
        }


        if ($subtotal < $coupon->min_order_amount) {
            return redirect()->route('checkout')->with('error',
                'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($coupon->min_order_amount) . 'đ để áp dụng mã giảm giá này');
        }

        if ($coupon->current_usage >= $coupon->usage_limit) {
            return redirect()->route('checkout')->with('error', 'Mã giảm giá đã hết lượt sử dụng');
        }

        if (!$this->canUsePromotion($coupon)) {
            return redirect()->route('checkout')->with('error', 'Bạn đã sử dụng mã giảm giá này đạt giới hạn');
        }

        // If all validations pass, set the coupon
        session(['selected_coupon' => $couponId]);
        return redirect()->route('checkout')->with('success', 'Áp dụng mã giảm giá thành công!');
    }


    public function removeCoupon()
    {
        session()->forget('selected_coupon');
        return redirect()->route('checkout')->with('success', 'Đã bỏ mã giảm giá');
    }

    public function cancel(Order $order)
    {
        if ($order->status_id !== 1) { // chỉ cho phép hủy khi đang pending
            return back()->with('error', 'Không thể hủy đơn hàng này.');
        }

        // Hoàn lại stock
        foreach ($order->orderItems as $item) {
            ProductVariant::where('id', $item->product_variant_id)
                ->increment('stock_quantity', $item->quantity);
        }

        $order->update(['status_id' => 5]); // 5 = cancelled (tùy bạn)

        return back()->with('success', 'Đơn hàng đã được hủy và hoàn tồn kho.');
    }

}
