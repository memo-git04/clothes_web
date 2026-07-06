@extends('layouts.app')

@section('content')
    <main class="min-h-screen bg-white mt-1">
        <div class="mx-auto max-w-7xl lg:px-12 lg:py-10">
            <a href="/shop" class="group mb-12 inline-flex items-center gap-2 font-sans text-xs uppercase tracking-[0.15em] text-gray-500 hover:text-black">
                ← Quay trở lại cửa hàng
            </a>

            @if(empty($cartItems))
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <h1 class="font-italic text-4xl">Giỏ hàng của bạn trống</h1>
                    <a href="{{route('shop')}}" class="mt-8 bg-black text-white px-10 py-4 text-xs uppercase tracking-widest">Tiếp tục mua sắm</a>
                </div>
            @else
                <div>
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="font-serif text-4xl font-light">Giỏ hàng</h1>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Xóa toàn bộ giỏ hàng?')">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-700 text-sm flex items-center gap-1">
                                🗑 Xóa tất cả
                            </button>
                        </form>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">
                        <!-- Cart Items -->
                        <div class="flex-1">
                            <!-- ... Giữ nguyên phần hiển thị sản phẩm ... -->
                            <div class="hidden lg:grid grid-cols-12 gap-4 border-b pb-4 text-xs uppercase tracking-widest text-gray-400">
                                <div class="col-span-6">sản phẩm</div>
                                <div class="col-span-2 text-center">giá</div>
                                <div class="col-span-2 text-center">số lương</div>
                                <div class="col-span-2 text-right">tổng tiền</div>
                            </div>

                            <div class="divide-y">
                                @foreach($cartItems as $item)
                                    <div class="py-8 grid grid-cols-12 gap-4 lg:items-center">
                                        <div class="col-span-12 lg:col-span-6 flex gap-6">
                                            <div class="w-24 h-24 lg:w-28 lg:h-28 bg-gray-100 overflow-hidden flex-shrink-0">
                                                <img
                                                     src="{{ $item['image'] }}"
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <a href="/product/{{ $item['id'] }}" class="font-medium hover:underline">{{ $item['name'] }}</a>
                                                <div class="text-sm text-gray-500 mt-1">
                                                    Size: {{ $item['size_name'] ?? 'N/A' }} |
                                                    Màu: {{ $item['color_name'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-span-6 lg:col-span-2 text-right lg:text-center">
                                            <span class="font-medium">{{ number_format($item['price']) }}</span>
                                        </div>

                                        <div class="col-span-6 lg:col-span-2">
                                            <form action="{{ route('cart.update-quantity') }}" method="POST" class="flex justify-center">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                <div class="flex border border-gray-300">
                                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-1 hover:bg-gray-100">-</button>
                                                    <span class="px-6 py-1 border-x">{{ $item['quantity'] }}</span>
                                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1 hover:bg-gray-100">+</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="col-span-12 lg:col-span-2 text-right flex justify-between lg:block">
                                            <span class="font-medium">{{ number_format($item['price'] * $item['quantity']) }}</span>
                                            <form action="{{ route('cart.remove') }}" method="POST" class="inline" onsubmit="return confirm('Xóa sản phẩm này?')">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                <button type="submit" class="text-red-500 hover:text-red-700 lg:ml-4">×</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="lg:w-96">
                            <div class="sticky top-8 border p-8">
                                <h2 class="text-2xl font-light mb-6">Tổng đơn hàng</h2>
                                @php
                                    $subtotal = collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity']);
                                    $selectedCoupon = $selectedCoupon ?? null;
                                    $discount = 0;
                                    $discountText = '';

                                    if ($selectedCoupon) {
                                        if ($selectedCoupon->discount_type === 'percent') {
                                            $discount = round($subtotal * ($selectedCoupon->discount_value / 100));
                                            $discountText = "-{$selectedCoupon->discount_value}%";
                                        } else {
                                            $discount = $selectedCoupon->discount_value;
                                            $discountText = "-" . number_format($discount) . " VNĐ";
                                        }
                                        $discount = min($discount, $subtotal);
                                    }
                                    $total = $subtotal - $discount;
                                @endphp

                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span>Tổng tiền</span>
                                        <span>{{ number_format($subtotal) }}</span>
                                    </div>

{{--                                    @if($selectedCoupon)--}}
{{--                                        <div class="flex justify-between text-green-600">--}}
{{--                                            <span>Giảm giá ({{ $selectedCoupon->code }})</span>--}}
{{--                                            <span>{{ $discountText }}</span>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}

                                    <div class="flex justify-between font-medium pt-4 border-t text-lg">
                                        <span>Thành tiền</span>
                                        <span>{{ number_format($subtotal) }} VNĐ</span>
                                    </div>
                                </div>

                                <button onclick="window.location.href='{{route('checkout')}}'"
                                        class="w-full mt-8 bg-black text-white py-5 text-xs uppercase tracking-widest hover:bg-gray-900">
                                    Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection
