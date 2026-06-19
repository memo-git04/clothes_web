@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 120px; margin-bottom: 100px;">
        <div class="card shadow">
            <div class="card-header bg-white border-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Chi tiết đơn hàng #{{ $order->order_code ?? $order->id }}</h3>
                    <a href="{{ route('orderHistory') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <!-- Thông tin đơn hàng -->
                    <div class="col-lg-5">
                        <h5 class="border-bottom pb-2">Thông tin đặt hàng</h5>
                        <div class="mb-3">
                            <strong>Khách hàng:</strong> {{ $order->receiver_name ?? $order->user->full_name ?? 'N/A' }}
                        </div>
                        <div class="mb-3">
                            <strong>SĐT:</strong> {{ $order->receiver_phone ?? $order->user->phone }}
                        </div>
                        <div class="mb-3">
                            <strong>Địa chỉ:</strong> {{ $order->receiver_address }}
                        </div>
                        <div class="mb-3">
                            <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div>
                            <strong>Trạng thái:</strong>
                            <span class="badge {{ match($order->status_id) {
                            5 => 'bg-success',
                            6 => 'bg-danger',
                            default => 'bg-primary'
                        } }} px-3 py-2">
                            {{ $order->status->status_name }}
                        </span>
                        </div>
                    </div>

                    <!-- Sản phẩm -->
                    <div class="col-lg-7">
                        <h5 class="border-bottom pb-2">Danh sách sản phẩm</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th class="text-end">Giá</th>
                                    <th class="text-center">SL</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td style="width: 90px;">
                                            <img src="{{ asset('storage/' . ($item->variant->images->first()->image_url ?? $item->productVariant->images->first()->url ?? '')) }}"
                                                 class="img-fluid rounded" style="max-height: 90px; object-fit: cover;" alt="">
                                        </td>
                                        <td>{{ $item->productVariant->product->product_name ?? 'N/A' }}</td>
                                        <td class="text-end">{{ number_format($item->price) }} VNĐ</td>
                                        <td class="text-center fw-bold">{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tổng tiền -->
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <h4 class="text-danger fw-bold">
                            Tổng thanh toán: {{ number_format($order->total_amount) }} VNĐ
                        </h4>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white border-0">
                @if($order->status_id == 1)
                    <form action="{{ route('order.cancel', $order) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                            <i class="fa-solid fa-ban"></i> Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
