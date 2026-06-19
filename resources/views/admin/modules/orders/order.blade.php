@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quản lý Đơn hàng</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách Đơn hàng</h4>

                    <!-- Filter Buttons -->
                    <div class="mb-4">
                        <a href="{{ route('admin.orders.filterOrder', 1) }}" class="btn btn-success btn-sm">Chờ xác nhận</a>
                        <a href="{{ route('admin.orders.filterOrder', 2) }}" class="btn btn-success btn-sm">Chờ lấy hàng</a>
                        <a href="{{ route('admin.orders.filterOrder', 3) }}" class="btn btn-warning btn-sm">Đang lấy hàng</a>
                        <a href="{{ route('admin.orders.filterOrder', 4) }}" class="btn btn-info btn-sm">Đang vận chuyển</a>
                        <a href="{{ route('admin.orders.filterOrder', 5) }}" class="btn btn-primary btn-sm">Giao thành công</a>
                        <a href="{{ route('admin.orders.filterOrder', 6) }}" class="btn btn-danger btn-sm">Đã hủy</a>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">Tất cả</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $order->order_code }}</strong></td>
                                    <td>{{ $order->user->full_name ?? $order->receiver_name ?? 'N/A' }}</td>
                                    <td>{{ number_format($order->final_amount ?? $order->total_amount) }} VNĐ</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $order->status_id == 5 ? 'success' : ($order->status_id == 6 ? 'danger' : 'primary') }}">
                                            {{ $order->status->status_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.items', $order->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.orders.items', $order->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <th>ID</th>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
