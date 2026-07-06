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
                                        4 => 'bg-green-50 text-green-700 border-green-200',
                                        5 => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-blue-50 text-blue-700 border-blue-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $statusClass }}">
                                    {{ $order->status->status_name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <strong class="text-gray-900">Thanh toán:</strong>
                                @php
                                    // Nếu đơn đã giao thành công, luôn hiển thị là đã thanh toán
                                    $paymentStatus = ($order->status_id == 4) ? 'paid' : ($order->payment->status ?? 'pending');
                                    $paymentClass = match($paymentStatus) {
                                        'paid' => 'bg-green-50 text-green-700 border-green-200',
                                        'failed' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-yellow-50 text-yellow-700 border-yellow-200'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold border {{ $paymentClass }}">
                                    {{ $paymentStatus === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán'}}
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
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-center">Size</th>
                                    <th class="border-b border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 text-center">Màu</th>
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
                                            {{ $item->variant->product->product_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-2 text-sm font-medium text-gray-800 text-left">
                                            {{ $item->variant->size->size_name ?? 'N/A' }}
                                        </td>
                                        <td class="px-3 py-2 text-sm font-medium text-gray-800 text-left">
                                            {{ $item->variant->color->color_name ?? 'N/A' }}
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

                @if($order->status_id == 4)
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <h5 class="text-base font-bold text-gray-800 mb-4">Đánh giá sản phẩm</h5>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="border border-gray-200 rounded p-4">
                                    <p class="text-sm font-medium text-gray-800 mb-2">
                                        {{ $item->variant->product->product_name ?? 'N/A' }}
                                    </p>
                                    @if($item->review)
                                        <div class="flex items-center gap-1 mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $item->review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                            @if($item->review->is_approved)
                                                <span class="ml-2 text-xs text-green-600">Đã duyệt</span>
                                            @else
                                                <span class="ml-2 text-xs text-yellow-600">Chờ duyệt</span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $item->review->comment }}</p>
                                    @else
                                        <form action="{{ route('reviews.store') }}" method="POST" class="flex flex-col sm:flex-row gap-2 items-start">
                                            @csrf
                                            <input type="hidden" name="order_item_id" value="{{ $item->id }}">
                                            <select name="rating" required class="border border-gray-200 py-1.5 px-2 text-sm">
                                                <option value="">Số sao</option>
                                                @for($s = 5; $s >= 1; $s--)
                                                    <option value="{{ $s }}">{{ $s }} sao</option>
                                                @endfor
                                            </select>
                                            <input type="text" name="comment" placeholder="Nhận xét của bạn..."
                                                   class="flex-1 border border-gray-200 py-1.5 px-2 text-sm min-w-[200px]">
                                            <button type="submit" class="px-4 py-1.5 bg-black text-white text-xs uppercase tracking-widest hover:opacity-80 transition">Gửi</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8 pt-4 border-t border-gray-100 text-right">
                    <h4 class="text-xl font-bold text-red-600">
                        Tổng thanh toán: {{ number_format($order->final_amount) }} VNĐ
                        @if($order->discount_amount > 0)
                            <span class="text-sm text-gray-600 ml-2">
                                (Giảm giá: {{ number_format($order->discount_amount) }} VNĐ)
                            </span>
                        @endif
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
