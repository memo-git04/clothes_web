@extends('admin.dashboard')

@section('content')
    <style>
        #order_status option:disabled {
            color: #999 !important;
            background-color: #f1f1f1 !important;
            cursor: not-allowed;
        }

        #order_status option {
            padding: 10px 12px;
            font-size: 16px;
        }

        #order_status option:hover:not(:disabled) {
            background-color: #d1e7dd !important;
            color: #0f5132;
        }
    </style>
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Chi tiết Đơn hàng</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Chi tiết Đơn hàng #{{ $order->order_code }}</h6>
                </div>
                <div class="card-body shadow">
                    <!-- Customer Info -->
                    <div class="row">
                        <div class="col-sm-6">
                            <label><b>Thông tin khách hàng</b></label>
                            <hr>
                            <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                            <p><strong>Khách hàng:</strong> {{ $order->user->full_name }}</p>
                            <p><strong>SĐT:</strong> {{ $order->user->phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->user->address }}</p>
                            <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount) }} VNĐ</p>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Trạng thái hiện tại:</strong>
                                <span class="text-primary">{{ $order->status->status_name }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="mt-4">
                        <label><b>Thông tin sản phẩm</b></label>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <img width="70px" height="100px"
                                             src="{{asset('storage/'. ($item->variant->images->first()->image_url ?? '')) }}"
                                             alt="product">
                                    </td>
                                    <td>{{ $item->variant->product->product_name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price) }} VNĐ</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Update Status Form -->
            <div class="row" style="margin-left: 15px;">
                <div class="col-md-12">
                    @if($showUpdateForm)
                        <form action="{{ route('admin.orders.updateOrder', $order->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label><strong>Chọn trạng thái mới:</strong></label>
                                <select name="order_status" class="form-control" style="width: 400px;">
                                    @foreach($statuses as $status)
                                        @php
                                          $isCurrent = $order->status_id == $status->id;
                                        @endphp
                                        <option
                                            value="{{ $status->id }}"
                                            @if(!in_array($status->id, $validStatuses))
                                            disabled
                                            @endif
                                            {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->status_name }}
                                            @if($isCurrent)
                                                (Hiện tại)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success mb-5">Cập nhật trạng thái</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mb-5">Quay lại danh sách</a>
                        </form>
                    @else
                        <div class="alert alert-{{ $order->status_id == 5 ? 'success' : 'danger' }}">
                            <strong>Đơn hàng đã {{ $order->status_id == 5 ? 'giao thành công' : 'bị hủy' }}.
                                Không thể thay đổi trạng thái nữa.</strong>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
