@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4" style="margin-top: 120px; margin-bottom: 100px;">

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Lịch sử đơn hàng của bạn</h2>
        </div>

        <div class="mb-6 flex flex-wrap justify-center gap-2">
            <a href="{{ route('orderHistory') }}" class="px-3 py-1.5 text-xs font-medium rounded border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">Tất cả</a>
            <a href="{{ route('orders.filter', 1) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-yellow-300 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 transition">Chờ xác nhận</a>
            <a href="{{ route('orders.filter', 2) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-blue-300 bg-blue-50 text-blue-700 hover:bg-blue-100 transition">Chờ lấy hàng</a>
            <a href="{{ route('orders.filter', 3) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-indigo-300 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition">Đang lấy hàng</a>
            <a href="{{ route('orders.filter', 4) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-cyan-300 bg-cyan-50 text-cyan-700 hover:bg-cyan-100 transition">Đang vận chuyển</a>
            <a href="{{ route('orders.filter', 5) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-green-300 bg-green-50 text-green-700 hover:bg-green-100 transition">Giao thành công</a>
            <a href="{{ route('orders.filter', 6) }}" class="px-3 py-1.5 text-xs font-medium rounded border border-red-300 bg-red-50 text-red-700 hover:bg-red-100 transition">Đã hủy</a>
        </div>

        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-200 align-middle">
                <thead class="bg-gray-50">
                <tr>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-center w-[15%]">Mã đơn</th>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-left w-[35%]">Sản phẩm</th>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-right w-[15%]">Tổng tiền</th>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-center w-[15%]">Ngày đặt</th>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-center w-[10%]">Trạng thái</th>
                    <th class="border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-700 text-center w-[10%]">Hành động</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border border-gray-200 px-4 py-3 text-sm font-bold text-center text-gray-800">
                            #{{ $order->order_code ?? $order->id }}
                        </td>
                        <td class="border border-gray-200 px-4 py-3 text-sm text-gray-700 text-left">
                            <div class="font-medium text-gray-900">
                                {{ $order->orderItems->first()?->productVariant?->product?->product_name ?? 'N/A' }}
                            </div>
                            @if($order->orderItems->count() > 1)
                                <div class="text-xs text-gray-500 mt-1">
                                    +{{ $order->orderItems->count() - 1 }} sản phẩm khác
                                </div>
                            @endif
                        </td>
                        <td class="border border-gray-200 px-4 py-3 text-sm font-bold text-right text-red-600">
                            {{ number_format($order->total_amount) }} VNĐ
                        </td>
                        <td class="border border-gray-200 px-4 py-3 text-sm text-center text-gray-600">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="border border-gray-200 px-4 py-3 text-sm text-center">
                            @php
                                $statusClass = match($order->status_id) {
                                    1 => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    2,3 => 'bg-blue-50 text-blue-700 border-blue-200',
                                    4 => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                    5 => 'bg-green-50 text-green-700 border-green-200',
                                    6 => 'bg-red-50 text-red-700 border-red-200',
                                    default => 'bg-gray-50 text-gray-700 border-gray-200'
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded text-xs font-semibold border {{ $statusClass }}">
                                    {{ $order->status->status_name }}
                                </span>
                        </td>
                        <td class="border border-gray-200 px-4 py-3 text-sm text-center">
                            <a href="{{ route('orderDetail', $order) }}" class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700 transition">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
