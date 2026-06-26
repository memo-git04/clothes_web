@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-4" style="margin-top: 120px; margin-bottom: 100px;">
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">

            <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h3 class="text-xl font-bold text-gray-800">Chi tiết đơn hàng #{{ $order->order_code ?? $order->id }}</h3>
                    <a href="{{ route('orderHistory') }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Quay lại
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <div class="lg:col-span-5 space-y-4">
                        <h5 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">Thông tin đặt hàng</h5>
                        <div class="text-sm text-gray-700 space-y-2.5">
                            <div><strong class="text-gray-900">Khách hàng:</strong> {{ $order->receiver_name ?? $order->user->full_name ?? 'N/A' }}</div>
                            <div><strong class="text-gray-900">SĐT:</strong> {{ $order->receiver_phone ?? $order->user->phone }}</div>
                            <div><strong class="text-gray-900">Địa chỉ:</strong> {{ $order->receiver_address }}</div>
                            <div><strong class="text-gray-900">Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</div>
                            <div class="flex items-center gap-2">
                                <strong class="text-gray-900">Trạng thái:</strong>
                                @php
                                    $statusClass = match($order->status_id) {
                                        5 => 'bg-green-50 text-green-700 border-green-200',
                                        6 => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-blue-50 text-blue-700 border-blue-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $statusClass }}">
                                    {{ $order->status->status_name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7 space-y-4">
                        <h5 class="text-base font-bold text-gray-800 border-b border-gray-200 pb-2">Danh sách sản phẩm</h5>
                        <div class="bg-white border border-gray-200 rounded overflow-x-auto">
                            <table class="min-w-full border-collapse align-middle">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-center w-[80px]">Hình ảnh</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-left">Sản phẩm</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-right w-[110px]">Giá</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-center w-[50px]">SL</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                @foreach($order->orderItems as $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-3 py-2 text-center">
                                            <img src="{{ asset('storage/' . ($item->variant->images->first()->image_url ?? $item->productVariant->images->first()->url ?? '')) }}"
                                                 class="w-16 h-16 object-cover rounded border border-gray-200 mx-auto" alt="">
                                        </td>
                                        <td class="px-3 py-2 text-sm font-medium text-gray-800 text-left">
                                            {{ $item->productVariant->product->product_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-2 text-sm font-medium text-gray-900 text-right">
                                            {{ number_format($item->price) }} VNĐ
                                        </td>
                                        <td class="px-3 py-2 text-sm font-bold text-center text-gray-700">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="mt-8 pt-4 border-t border-gray-100 text-right">
                    <h4 class="text-xl font-bold text-red-600">
                        Tổng thanh toán: {{ number_format($order->total_amount) }} VNĐ
                    </h4>
                </div>
            </div>
            <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
                @if($order->status_id == 1)
                    <form action="{{ route('order.cancel', $order) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition"
                                onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                            Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>

        </div>
    </div>
@endsection
