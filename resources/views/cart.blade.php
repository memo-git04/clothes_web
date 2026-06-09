@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-white" 
    x-data="{ 
        cartItems: {{ json_encode($cartItems) }},
        couponOpen: false,
        couponCode: '',
        shippingThreshold: 500,
        shippingCost: 15,
        
        get subtotal() {
            return this.cartItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },
        get currentShipping() {
            return this.subtotal > this.shippingThreshold ? 0 : this.shippingCost;
        },
        get total() {
            return this.subtotal + this.currentShipping;
        },
        updateQuantity(id, delta) {
            const item = this.cartItems.find(i => i.id == id);
            if (item) {
                item.quantity = Math.max(1, item.quantity + delta);
            }
        },
        removeItem(id) {
            this.cartItems = this.cartItems.filter(i => i.id != id);
        }
    }">
    
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-12 lg:py-20">
        <!-- Nút quay lại -->
        <a href="/shop" class="group mb-12 inline-flex items-center gap-2 font-sans text-xs uppercase tracking-[0.15em] text-gray-500 transition-colors hover:text-black">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Return to Shop
        </a>

        <!-- Empty State -->
        <template x-if="cartItems.length === 0">
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <h1 class="font-serif text-4xl font-light tracking-tight md:text-5xl">Your Cart is Empty</h1>
                <p class="mt-4 text-sm tracking-wide text-gray-500">Looks like you haven't added anything yet.</p>
                <a href="/shop" class="mt-10 inline-flex bg-black px-10 py-4 text-xs uppercase tracking-[0.2em] text-white hover:opacity-80 transition-opacity">
                    Continue Shopping
                </a>
            </div>
        </template>

        <!-- Main Content -->
        <template x-if="cartItems.length > 0">
            <div>
                <h1 class="mb-12 font-serif text-4xl font-light tracking-tight text-black md:text-5xl lg:mb-16">Shopping Cart</h1>

                <div class="flex flex-col gap-12 lg:flex-row lg:gap-16">
                    <!-- Left Side: Cart Items -->
                    <div class="flex-1 lg:w-[65%]">
                        <!-- Header Desktop -->
                        <div class="hidden border-b border-[#eeeeee] pb-4 lg:grid lg:grid-cols-12 lg:gap-6">
                            <div class="col-span-6"><span class="text-[10px] uppercase tracking-[0.2em] text-gray-400">Product</span></div>
                            <div class="col-span-2 text-center"><span class="text-[10px] uppercase tracking-[0.2em] text-gray-400">Price</span></div>
                            <div class="col-span-2 text-center"><span class="text-[10px] uppercase tracking-[0.2em] text-gray-400">Quantity</span></div>
                            <div class="col-span-2 text-right"><span class="text-[10px] uppercase tracking-[0.2em] text-gray-400">Subtotal</span></div>
                        </div>

                        <div class="divide-y divide-[#eeeeee]">
                            <template x-for="item in cartItems" :key="item.id">
                                <div class="py-8 lg:grid lg:grid-cols-12 lg:items-center lg:gap-6">
                                    <!-- Info -->
                                    <div class="col-span-6 flex gap-6">
                                        <div class="relative aspect-[3/4] w-24 flex-shrink-0 bg-[#f5f5f5] lg:w-28 overflow-hidden">
                                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <a :href="'/product/' + item.id" class="font-serif text-base font-light tracking-tight hover:text-gray-500 lg:text-lg" x-text="item.name"></a>
                                            <div class="mt-2 flex gap-x-4 text-xs text-gray-500">
                                                <span x-text="'Size: ' + item.size"></span>
                                                <span x-text="'Color: ' + item.color"></span>
                                            </div>
                                            <!-- Mobile Only -->
                                            <div class="mt-4 flex items-center gap-6 lg:hidden">
                                                <div class="flex items-center border border-[#eeeeee]">
                                                    <button @click="updateQuantity(item.id, -1)" class="p-2 hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 12H4" /></svg></button>
                                                    <span class="w-8 text-center text-sm" x-text="item.quantity"></span>
                                                    <button @click="updateQuantity(item.id, 1)" class="p-2 hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" /></svg></button>
                                                </div>
                                                <button @click="removeItem(item.id)" class="text-[10px] uppercase tracking-widest text-gray-400">Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price Desktop -->
                                    <div class="col-span-2 hidden text-center lg:block text-sm" x-text="'$' + item.price.toFixed(2)"></div>

                                    <!-- Qty Desktop -->
                                    <div class="col-span-2 hidden items-center justify-center lg:flex">
                                        <div class="flex items-center border border-[#eeeeee]">
                                            <button @click="updateQuantity(item.id, -1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M20 12H4" /></svg></button>
                                            <span class="w-10 text-center text-sm" x-text="item.quantity"></span>
                                            <button @click="updateQuantity(item.id, 1)" class="w-10 h-10 flex items-center justify-center hover:bg-gray-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 4v16m8-8H4" /></svg></button>
                                        </div>
                                    </div>

                                    <!-- Subtotal Desktop -->
                                    <div class="col-span-2 hidden items-center justify-end gap-4 lg:flex">
                                        <span class="text-sm font-medium" x-text="'$' + (item.price * item.quantity).toFixed(2)"></span>
                                        <button @click="removeItem(item.id)" class="text-gray-300 hover:text-black">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Right Side: Order Summary -->
                    <div class="lg:w-[35%]">
                        <div class="sticky top-8 border border-[#eeeeee] p-8 lg:p-10">
                            <h2 class="mb-8 font-serif text-2xl font-light">Order Summary</h2>
                            
                            <div class="space-y-4 border-b border-[#eeeeee] pb-6">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Subtotal</span>
                                    <span x-text="'$' + subtotal.toFixed(2)"></span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Shipping</span>
                                    <span x-text="currentShipping === 0 ? 'Free' : '$' + currentShipping.toFixed(2)"></span>
                                </div>
                                <p x-show="subtotal < shippingThreshold" class="text-[10px] text-gray-400 italic">
                                    Free shipping on orders over $500
                                </p>
                            </div>

                            <!-- Coupon -->
                            <div class="border-b border-[#eeeeee] py-6">
                                <button @click="couponOpen = !couponOpen" class="flex w-full items-center justify-between text-sm">
                                    <span>Have a coupon?</span>
                                    <svg :class="couponOpen ? 'rotate-180' : ''" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="couponOpen" x-transition class="mt-4 flex gap-3">
                                    <input type="text" x-model="couponCode" placeholder="Enter code" class="flex-1 border border-[#eeeeee] px-4 py-3 text-sm focus:outline-none">
                                    <button class="border border-black px-6 py-3 text-[10px] uppercase tracking-widest hover:bg-black hover:text-white transition-colors">Apply</button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-6">
                                <span class="text-xs uppercase tracking-widest font-semibold">Total</span>
                                <span class="font-serif text-2xl" x-text="'$' + total.toFixed(2)"></span>
                            </div>

                            <button class="w-full bg-black py-5 text-xs uppercase tracking-[0.2em] text-white hover:opacity-90 transition-opacity">
                                Proceed to Checkout
                            </button>

                            <div class="mt-6 text-center">
                                <p class="text-[10px] uppercase text-gray-400 tracking-widest">Secure checkout with</p>
                                <div class="mt-3 flex justify-center gap-4 text-[10px] text-gray-500 font-medium">
                                    <span>VISA</span><span>MASTERCARD</span><span>AMEX</span><span>PAYPAL</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</main>
@endsection