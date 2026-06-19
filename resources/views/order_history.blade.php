@extends('layouts.app')

@section('content')
    <div class="" style="margin-top: 120px; margin-bottom: 100px;">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="fw-bold text-dark">Lịch sử đơn hàng của bạn</h2>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="mb-4 text-center">
            <a href="{{ route('orderHistory') }}" class="btn btn-outline-secondary btn-sm mx-1">Tất cả</a>
            <a href="{{ route('orders.filter', 1) }}" class="btn btn-warning btn-sm mx-1">Chờ xác nhận</a>
            <a href="{{ route('orders.filter', 2) }}" class="btn btn-info btn-sm mx-1">Chờ lấy hàng</a>
            <a href="{{ route('orders.filter', 3) }}" class="btn btn-primary btn-sm mx-1">Đang lấy hàng</a>
            <a href="{{ route('orders.filter', 4) }}" class="btn btn-info btn-sm mx-1">Đang vận chuyển</a>
            <a href="{{ route('orders.filter', 5) }}" class="btn btn-success btn-sm mx-1">Giao thành công</a>
            <a href="{{ route('orders.filter', 6) }}" class="btn btn-danger btn-sm mx-1">Đã hủy</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th class="ps-4">Mã đơn</th>
                            <th>Sản phẩm</th>
                            <th class="text-end">Tổng tiền</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $order->order_code ?? $order->id }}</td>
                                <td>
                                    {{ $order->orderItems->first()?->productVariant?->product?->product_name ?? 'N/A' }}
                                    @if($order->orderItems->count() > 1)
                                        <small class="text-muted">+{{ $order->orderItems->count() - 1 }} sản phẩm khác</small>
                                    @endif
                                </td>
                                <td class="text-end fw-bold">{{ number_format($order->total_amount) }} VNĐ</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $statusClass = match($order->status_id) {
                                            1 => 'bg-warning',
                                            2,3 => 'bg-info',
                                            4 => 'bg-primary',
                                            5 => 'bg-success',
                                            6 => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-3 py-2">
                                        {{ $order->status->status_name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('orderDetail', $order) }}" class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-eye"></i> Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
