@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white">
        <div class="flex flex-col lg:flex-row max-w-[1400px] mx-auto" style="margin-top: 20px; margin-bottom: 20px">

            <!-- LEFT: FORM -->
            <div class="flex-1 lg:pr-12 xl:pr-20 border-r border-gray-100">
                <div class="max-w-xl ml-auto px-6 py-10 lg:py-16">
                    <nav class="mb-10">
                        <ol class="flex items-center gap-3 text-[10px] uppercase tracking-[0.2em]">
                            <li><a href="{{route('cart.index')}}" class="text-gray-500 hover:text-black">Giỏ hàng</a></li>
                            <li>/</li>
                            <li class="text-black font-bold">Đặt hàng</li>
                        </ol>
                    </nav>

                    <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <!-- CONTACT -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Thông tin liên hệ</h2>
                            <input type="email" name="email" placeholder="Email" value="{{ $user->email }}"
                                   class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                        </section>

                        <!-- SHIPPING -->
                        <section class="mb-12">
                            <div class="space-y-5">
                                <label class="text-xs uppercase tracking-widest font-semibold mb-4">Thông tin người nhận</label>
                                <input type="text" name="receiver_name" placeholder="Họ tên" value="{{ $user->full_name }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                <input type="text" name="receiver_phone" placeholder="Số điện thoại" value="{{ $user->phone }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                <input type="text" name="receiver_address" placeholder="Địa chỉ" value="{{ $user->address }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                            </div>
                        </section>

                        <!-- PAYMENT -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-4">Phương thức thanh toán</h2>
                            <div class="space-y-3">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment_method" value="cod" class="accent-black" checked>
                                    <span class="text-sm text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment_method" value="online" class="accent-black">
                                    <span class="text-sm text-gray-700">Thanh toán Online (VNPay)</span>
                                </label>
                            </div>
                        </section>

                        <div class="flex justify-between items-center">
                            <a href="{{route('cart.index')}}" class="text-xs text-gray-500 hover:text-black">← Quay lại giỏ hàng</a>
                            <button type="submit" class="px-10 py-4 bg-black text-white text-xs uppercase tracking-widest hover:bg-gray-800">
                                Đặt đơn
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="w-full lg:w-[40%] bg-gray-50">
                <div class="max-w-md px-10 py-16">
                    @php
                        $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
                        $discount = 0;
                        if ($selectedCoupon && $subtotal >= $selectedCoupon->min_order_amount) {
                            $discount = $selectedCoupon->discount_value;
                            $discount = min($discount, $subtotal);
                        }
                        $total = $subtotal - $discount;
                    @endphp

                    <div class="space-y-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-20 bg-white border overflow-hidden">
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500">
                                        Size: {{ $item['size_name'] ?? '' }} |
                                        Màu: {{ $item['color_name'] ?? '' }}
                                    </p>
                                    <p class="text-xs">x{{ $item['quantity'] }}</p>
                                </div>
                                <p class="text-sm font-medium">{{ number_format($item['price'] * $item['quantity']) }} đ</p>
                            </div>
                        @endforeach

                        <div class="border-t pt-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span>Tổng tiền</span>
                                <span>{{ number_format($subtotal) }} đ</span>
                            </div>

                            @if($discount > 0)
                                <div class="flex justify-between text-sm text-green-600">
                                    <span>Giảm giá ({{ $selectedCoupon->code }})</span>
                                    <span>-{{ number_format($discount) }} đ</span>
                                </div>
                            @endif

                            <div class="flex justify-between font-bold text-lg border-t pt-4">
                                <span>Thành tiền</span>
                                <span>{{ number_format($total) }} đ</span>
                            </div>
                        </div>

                        <!-- Coupon Section -->
                        <section class="pt-6 border-t">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Mã giảm giá</h2>

                            @if($availableCoupons->isEmpty())
                                <p class="text-sm text-gray-500">Không có mã giảm giá nào khả dụng.</p>
                            @else
                                <form action="{{ route('checkout.apply-coupon') }}" method="POST" id="coupon-form">
                                    @csrf
                                    <div class="space-y-3">
                                        <!-- Không dùng mã -->
                                        <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-black transition-all
                                                 {{ !$selectedCoupon ? 'border-black bg-gray-50' : 'border-gray-200' }}">
                                            <input type="radio" name="coupon_id" value="0"
                                                   class="accent-black ml-6"
                                                   {{ !$selectedCoupon ? 'checked' : '' }}
                                                   onchange="handleCouponChange(this)">
                                            <span class="text-sm">Không dùng mã</span>
                                        </label>

                                        @foreach($availableCoupons as $coupon)
                                            <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer hover:border-black transition-all
                                                     {{ $selectedCoupon && $selectedCoupon->id === $coupon->id ? 'border-black bg-gray-50' : 'border-gray-200' }}">
                                                <div class="flex-1">
                                                    <div class="font-semibold">{{ $coupon->code }}</div>
                                                    <div class="text-sm text-gray-600">{{ $coupon->promotion_name }}</div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-green-600 font-bold">-{{ number_format($coupon->discount_value) }}đ</span>
                                                </div>
                                                <input type="radio" name="coupon_id" value="{{ $coupon->id }}"
                                                       class="accent-black ml-6"
                                                       {{ $selectedCoupon && $selectedCoupon->id === $coupon->id ? 'checked' : '' }}
                                                       onchange="handleCouponChange(this, {{ $coupon->min_order_amount }}, {{ $subtotal }})">
                                            </label>
                                        @endforeach
                                    </div>
                                </form>
                            @endif
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleCouponChange(radio, minAmount, subtotal) {
            const form = document.getElementById('coupon-form');

            // Nếu chọn "Không dùng mã" (value = 0)
            if (radio.value === "0") {
                form.submit();
                return;
            }

            // Nếu chọn mã giảm giá
            if (subtotal < minAmount) {
                alert(`Đơn hàng chưa đạt giá trị tối thiểu ${new Intl.NumberFormat('vi-VN').format(minAmount)}đ để áp dụng mã giảm giá này.`);
                radio.checked = false;
                return;
            }


            form.submit();
        }
    </script>
@endsection
