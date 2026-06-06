@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-white" 
     x-data="{ 
        step: 'information', 
        showSummary: false,
        isMobile: window.innerWidth < 1024 
     }"
     @resize.window="isMobile = window.innerWidth < 1024">
    
    <!-- Mobile Header (Chỉ hiện ở mobile) -->
    <header class="lg:hidden border-b border-gray-200 px-6 py-4 flex justify-center">
        <a href="/" class="font-serif text-xl tracking-wider uppercase">INNOVE</a>
    </header>

    <!-- Mobile Order Summary Toggle -->
    <div class="lg:hidden bg-gray-50 border-b border-gray-200">
        <button @click="showSummary = !showSummary" class="w-full px-6 py-4 flex items-center justify-between focus:outline-none">
            <span class="flex items-center gap-2 text-sm text-blue-600 font-medium">
                <svg x-show="!showSummary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                <svg x-show="showSummary" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                <span x-text="showSummary ? 'Ẩn thông tin đơn hàng' : 'Hiển thị thông tin đơn hàng'"></span>
            </span>
            <span class="font-serif text-lg text-black">$2,340</span>
        </button>
        
        <!-- Order Summary Mobile Content -->
        <div x-show="showSummary" x-collapse class="px-6 pb-6 border-t border-gray-200 pt-6">
            @template_summary
        </div>
    </div>

    <div class="flex flex-col lg:flex-row max-w-[1400px] mx-auto">
        <!-- CỘT TRÁI: FORM THANH TOÁN -->
        <div class="flex-1 lg:pr-12 xl:pr-20 border-r border-gray-100">
            <div class="max-w-xl ml-auto px-6 py-10 lg:py-16">
                
                <a href="/" class="hidden lg:block font-serif text-2xl tracking-wider mb-12 uppercase">INNOVE</a>

                <!-- Breadcrumbs -->
                <nav class="mb-10">
                    <ol class="flex items-center gap-3 text-[10px] uppercase tracking-[0.2em]">
                        <li><a href="/cart" class="text-gray-500 hover:text-black">Cart</a></li>
                        <li class="text-gray-300">/</li>
                        <li :class="step === 'information' ? 'text-black font-bold' : 'text-gray-400'">Information</li>
                        <li class="text-gray-300">/</li>
                        <li :class="step === 'shipping' ? 'text-black font-bold' : 'text-gray-400'">Shipping</li>
                        <li class="text-gray-300">/</li>
                        <li :class="step === 'payment' ? 'text-black font-bold' : 'text-gray-400'">Payment</li>
                    </ol>
                </nav>

                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                    @csrf

                    <!-- STEP 1: INFORMATION -->
                    <div x-show="step === 'information'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4">
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Shipping Address</h2>
                            <div class="space-y-5">
                                <input type="text" name="receiver_name" placeholder="Full Name" class="w-full py-3 border-b border-gray-200" required>
                                <input type="text" name="receiver_phone" placeholder="Phone Number" class="w-full py-3 border-b border-gray-200" required>
                                <input type="text" name="detailed_address" placeholder="Address" class="w-full py-3 border-b border-gray-200" required>
                                <div class="grid grid-cols-3 gap-4">
                                    <input type="text" name="province" placeholder="Province" class="py-3 border-b border-gray-200">
                                    <input type="text" name="district" placeholder="District" class="py-3 border-b border-gray-200">
                                    <input type="text" name="ward" placeholder="Ward" class="py-3 border-b border-gray-200">
                                </div>
                            </div>
                        </section>
                        <section class="mb-12">
                            <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Shipping Address</h2>
                            <div class="space-y-5">
                                <select name="country" class="w-full py-3 border-b border-gray-200 bg-transparent focus:outline-none focus:border-black">
                                    <option value="VN">Vietnam</option>
                                    <option value="US">United States</option>
                                </select>
                                
                                <div class="grid grid-cols-2 gap-6">
                                    <input type="text" name="first_name" placeholder="First Name" class="py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                    <input type="text" name="last_name" placeholder="Last Name" class="py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                </div>

                                <input type="text" name="address" placeholder="Address" class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                                <input type="text" name="city" placeholder="City" class="w-full py-3 border-b border-gray-200 focus:outline-none focus:border-black">
                            </div>
                        </section>

                        <div class="flex items-center justify-between pt-4">
                            <a href="/cart" class="text-xs text-gray-500 hover:text-black transition-colors">← Return to cart</a>
                            <button type="button" @click="step = 'shipping'" class="px-8 py-4 bg-black text-white text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 transition-all shadow-sm">
                                Continue to Shipping
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2: SHIPPING -->
                    <div x-show="step === 'shipping'" x-cloak x-transition:enter="transition ease-out duration-300">
                        <div class="border border-gray-200 rounded-sm mb-12 overflow-hidden">
                            <div class="p-4 flex justify-between items-center text-xs border-b border-gray-200">
                                <span class="text-gray-500 w-20">Contact</span>
                                <span class="flex-1 text-gray-900 px-4">user@example.com</span>
                                <button type="button" @click="step = 'information'" class="text-blue-600 hover:underline">Change</button>
                            </div>
                            <div class="p-4 flex justify-between items-center text-xs">
                                <span class="text-gray-500 w-20">Ship to</span>
                                <span class="flex-1 text-gray-900 px-4">123 Street Name, Hanoi, VN</span>
                                <button type="button" @click="step = 'information'" class="text-blue-600 hover:underline">Change</button>
                            </div>
                        </div>

                        <h2 class="text-xs uppercase tracking-widest font-semibold mb-6">Shipping Method</h2>
                        <div class="border border-gray-200 rounded-sm divide-y divide-gray-200 mb-10">
                            <label class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="shipping_method" value="standard" checked class="w-4 h-4 accent-black">
                                    <span class="text-sm">Standard Shipping</span>
                                </div>
                                <span class="text-sm font-medium">Free</span>
                            </label>
                            <label class="flex justify-between items-center p-4 cursor-pointer hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-4">
                                    <input type="radio" name="shipping_method" value="express" class="w-4 h-4 accent-black">
                                    <span class="text-sm">Express Shipping</span>
                                </div>
                                <span class="text-sm font-medium">$25.00</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="step = 'information'" class="text-xs text-gray-500 hover:text-black">← Back to Information</button>
                            <button type="button" @click="step = 'payment'" class="px-8 py-4 bg-black text-white text-[10px] uppercase tracking-[0.2em] hover:bg-gray-800 transition-all">
                                Continue to Payment
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3: PAYMENT -->
                    <div x-show="step === 'payment'" x-cloak x-transition:enter="transition ease-out duration-300">
                        <h2 class="text-xs uppercase tracking-widest font-semibold mb-2">Payment</h2>
                        <p class="text-[11px] text-gray-500 mb-6 font-serif italic">All transactions are secure and encrypted.</p>
                        
                        <div class="border border-gray-200 rounded-sm p-8 bg-gray-50 text-center mb-10">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <p class="text-sm text-gray-600">Please click "Pay Now" to complete your purchase via secure gateway.</p>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="button" @click="step = 'shipping'" class="text-xs text-gray-500 hover:text-black">← Back to Shipping</button>
                            <button type="submit" class="px-12 py-4 bg-black text-white text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-gray-800 transition-all">
                                Pay Now
                            </button>
                        </div>
                    </div>
                </form>

                <footer class="mt-20 pt-8 border-t border-gray-100 flex flex-wrap gap-6 text-[10px] text-gray-400 uppercase tracking-widest">
                    <a href="#" class="hover:text-black transition-colors">Refund Policy</a>
                    <a href="#" class="hover:text-black transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-black transition-colors">Terms of Service</a>
                </footer>
            </div>
        </div>

        <!-- CỘT PHẢI: ORDER SUMMARY (DESKTOP ONLY) -->
        <div class="hidden lg:block w-[40%] bg-gray-50 min-h-screen">
            <div class="max-w-md px-10 py-16 sticky top-0">
                @php
                    $cartItems = session()->get('cart', []);
                    $subtotal = array_reduce($cartItems, function ($sum, $item) {
                        return $sum + ($item['quantity'] * $item['price']);
                    }, 0);
                @endphp

                @foreach($cartItems as $item)
                <div class="flex items-center gap-4">
                    <p class="text-sm font-medium text-gray-900 font-serif">${{ number_format($item['price'] * $item['quantity']) }}</p>
                </div>
                @endforeach

<span class="text-black font-medium">${{ number_format($subtotal, 2) }}</span>

                <!-- Macro-like display for summary -->
                <div class="space-y-6">
                    @foreach($cartItems as $item)
                    <div class="flex items-center gap-4">
                        <div class="relative w-16 h-20 bg-white border border-gray-100 flex-shrink-0">
                            <img src="{{ $item['image'] }}" class="object-cover w-full h-full">
                            <span class="absolute -top-2 -right-2 w-5 h-5 bg-gray-500 text-white text-[10px] flex items-center justify-center rounded-full font-bold">
                                {{ $item['quantity'] }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-serif text-sm text-gray-900 tracking-tight">{{ $item['name'] }}</h4>
                            <p class="text-[11px] text-gray-400 uppercase tracking-widest mt-1">{{ $item['variant'] }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 font-serif">${{ number_format($item['price']) }}</p>
                    </div>
                    @endforeach

                    <div class="flex gap-3 py-6 border-y border-gray-200 mt-8">
                        <input type="text" placeholder="Discount code" class="flex-1 px-4 py-3 bg-white border border-gray-200 text-xs focus:outline-none focus:border-black transition-all">
                        <button class="px-5 py-3 bg-gray-200 text-gray-600 text-[10px] uppercase tracking-[0.2em] font-bold hover:bg-black hover:text-white transition-all disabled:opacity-50">Apply</button>
                    </div>

                    <div class="space-y-3 text-sm pt-2">
                        <div class="flex justify-between text-gray-500">
                            <span class="text-xs uppercase tracking-widest">Subtotal</span>
                            <span class="text-black font-medium">$2,340.00</span>
                        </div>
                        <div class="flex justify-between text-gray-500">
                            <span class="text-xs uppercase tracking-widest">Shipping</span>
                            <span class="text-[10px] italic">Calculated at next step</span>
                        </div>
                        <div class="flex justify-between pt-6 mt-6 border-t border-gray-200">
                            <span class="text-sm uppercase tracking-[0.2em] font-bold">Total</span>
                            <div class="text-right">
                                <span class="text-xs text-gray-400 mr-2 uppercase">USD</span>
                                <span class="font-serif text-2xl text-black">$2,340.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ẩn hiện bước mượt mà hơn */
    [x-cloak] { display: none !important; }
    
    input::placeholder {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #9ca3af;
    }
    
    select {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
</style>
@endsection