@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white flex items-center justify-center px-4" style="padding-top:120px;padding-bottom:120px;">
        <div class="max-w-md w-full text-center border border-gray-100 shadow-sm rounded-2xl p-10">
            @if(!empty($success))
                <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-green-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl font-serif tracking-wide mb-2">Thanh toán thành công</h1>
                <p class="text-gray-500 text-sm mb-6">
                    Cảm ơn bạn đã mua hàng.
                    @isset($order) Mã đơn: <span class="font-semibold text-black">{{ $order->order_code }}</span> @endisset
                </p>
            @else
                <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-red-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h1 class="text-2xl font-serif tracking-wide mb-2">Thanh toán không thành công</h1>
                <p class="text-gray-500 text-sm mb-6">
                    Giao dịch chưa hoàn tất hoặc đã bị hủy.
                    @isset($order) Đơn <span class="font-semibold">{{ $order->order_code }}</span> đã được hủy và hoàn tồn kho. @endisset
                </p>
            @endif

            <div class="flex gap-3 justify-center">
                <a href="{{ route('home') }}" class="px-5 py-2.5 text-[11px] uppercase tracking-[0.2em] border border-black hover:bg-black hover:text-white transition">Về trang chủ</a>
                @auth
                    <a href="{{ route('orderHistory') }}" class="px-5 py-2.5 text-[11px] uppercase tracking-[0.2em] bg-black text-white hover:opacity-80 transition">Xem đơn hàng</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
