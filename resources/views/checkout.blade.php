@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-white">
        <div class="flex flex-col lg:flex-row max-w-[1400px] mx-auto">

            ```
            <!-- LEFT: FORM -->
            <div class="flex-1 lg:pr-12 xl:pr-20 border-r border-gray-100">
                <div class="max-w-xl ml-auto px-6 py-10 lg:py-16">

                    <a href="/" class="font-serif text-2xl tracking-wider mb-12 uppercase block">INNOVE</a>

                    <!-- Breadcrumb -->
                    <nav class="mb-10">
                        <ol class="flex items-center gap-3 text-[10px] uppercase tracking-[0.2em]">
                            <li><a href="" class="text-gray-500 hover:text-black">Cart</a></li>
                            <li>/</li>
                            <li class="text-black font-bold">Checkout</li>
                        </ol>
                    </nav>

                    <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <!-- CONTACT -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Contact Information</h2>
                            <input type="email" name="email" placeholder="Email"
                                   value="{{ $user->email }}"
                                   class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black" required>
                        </section>

                        <!-- SHIPPING -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Shipping Address</h2>

                            <div class="space-y-5">
                                <input type="text" name="full_name" placeholder="Full Name"
                                       value="{{ $user->full_name }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                <input type="text" name="phone" placeholder="Phone"
                                       value="{{ $user->phone }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">

                                <input type="text" name="address" placeholder="Address"
                                       value="{{ $user->address }}"
                                       class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                            </div>
                        </section>

                        <!-- SHIPPING METHOD -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Shipping Method</h2>

                            <label class="flex justify-between items-center p-4 border cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="shipping_method" value="standard" checked>
                                    <span>Standard Shipping</span>
                                </div>
                                <span>Free</span>
                            </label>
                        </section>

                        <!-- PAYMENT -->
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-4">Payment</h2>
                            <p class="text-sm text-gray-500">Thanh toán khi nhận hàng (COD)</p>
                        </section>

                        <div class="flex justify-between items-center">
                            <a href="{{route('cart.index')}}" class="text-xs text-gray-500 hover:text-black">← Return to cart</a>
                            <button type="submit"
                                    class="px-10 py-4 bg-black text-white text-xs uppercase tracking-widest hover:bg-gray-800">
                                Place Order
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
                        $total = $subtotal;
                    @endphp

                    <div class="space-y-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-20 bg-white border">
                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover">
                                </div>

                                <div class="flex-1">
                                    <h4 class="text-sm">{{ $item['name'] }}</h4>
                                    <p class="text-xs text-gray-500">
                                        Size: {{ $item['size_name'] ?? '' }} |
                                        Color: {{ $item['color_name'] ?? '' }}
                                    </p>
                                    <p class="text-xs">x{{ $item['quantity'] }}</p>
                                </div>

                                <p class="text-sm font-medium">
                                    {{ number_format($item['price'] * $item['quantity']) }} đ
                                </p>
                            </div>
                        @endforeach

                        <div class="border-t pt-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal</span>
                                <span>{{ number_format($subtotal) }} đ</span>
                            </div>

                            <div class="flex justify-between text-sm">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>

                            <div class="flex justify-between font-bold text-lg border-t pt-4">
                                <span>Total</span>
                                <span>{{ number_format($total) }} đ</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        ```

    </div>
@endsection
