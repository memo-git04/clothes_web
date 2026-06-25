<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductVariant;
use App\Models\Promotion;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);
        $variant = ProductVariant::with(['product', 'size', 'color', 'images'])
            ->findOrFail($variantId);

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

    public function applyCoupon(Request $request)
    {
//        $couponCode = $request->coupon_code;

        $coupon = Promotion::where('id', $request->coupon_id)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if ($coupon) {
            session(['selected_coupon' => $coupon->id]);
            return redirect()->route('cart.index')->with('success', 'Áp dụng mã giảm giá thành công!');
        }

        return redirect()->route('cart.index')->with('error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn!');
    }

    public function removeCoupon()
    {
        session()->forget('selected_coupon');
        return redirect()->route('cart.index');
    }

    public function checkout(){
        $cart = session()->get('cart', []);
        $cartItems = [];

        foreach ($cart as $id => $item) {
            $cartItems[] = array_merge(['id' => $id], $item);
        }
        $user = auth()->user();

        return view('checkout',[
            'cartItems' => $cartItems,
            'user' => $user
        ]);
    }
    public function store(Request $request)
    {

        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $discount = 0;
        $final = $subtotal;

        if ($request->has('payment_method') && $request->payment_method === 'cod') {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD' . time(),
                'promotion_id' => null,
                'status_id' => 1, // pending (tuỳ DB bạn)
                'total_amount' => $subtotal,
                'discount_amount' => $discount,
                'final_amount' => $final,
            ]);

            foreach ($cartItems as $cartItemId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $cartItemId,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
        } else {
            $vnp_TmnCode = env('VNP_TMNCODE');
            $vnp_HashSecret = env('VNP_HASH_SECRET');
            $vnp_Url = env('VNP_URL');
            $vnp_Returnurl = "http://localhost:8000/payment-return";
            $vnp_TxnRef = 'ORD' . time();
            $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $final * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = request()->ip();

            $inputData = array(
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

//            dd($inputData);

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
                $vnpSecureHash = hash_hmac('sha512', $hashdata , $vnp_HashSecret);
                $vnp_Url .= 'vnp_SecureHashType=SHA512&vnp_SecureHash=' . $vnpSecureHash;
            }

//            dd($vnp_Url);

            session()->forget('cart');
            return redirect($vnp_Url);
        }

    }

}
