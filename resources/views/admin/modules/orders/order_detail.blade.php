@extends('admin.layouts.dashboard')
@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Item</h6>
                </div>
                <div class="card-body shadow">
                    <form class="row" action="{{route('orders.updateOrder', $order->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1"><b>Customer information</b></label>
                            <hr>
                            <p>Order ID: {{ $order->id }}</p>
                            <p>Customer: {{ $order->receiver_name }}</p>
                            <p>Phone: {{ $order->receiver_phone }}</p>
                            <p>Address: {{ $order->receiver_address }}</p>
                            <p>Total order: $ {{ number_format($order->total_amount, 2) }}</p>
                            <p>Order Date: {{ $order->order_date }}</p>
                            <p>Status:
                                <span class="text text-primary">
                                    {{ $order->status->status_name }}
                                </span>
                            </p>
                            <hr>
                        </div>

                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1"><b>Product information</b></label>
                        </div>
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Img</th>
                                        <th style="width: 450px;">Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>
                                                <img width="70px" height="100px"
                                                     src="{{asset(\Illuminate\Support\Facades\Storage::url('images/'). $item->productVariant->images->first()->url ?? '#') }}" alt="">
                                            </td>
                                            <td>{{ $item->productVariant->product->product_name ?? 'N/A' }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>$ {{ number_format($item->price, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    <hr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row" style="margin-left: 15px;">
                <div class="col-md-12">
                    @if($showUpdateForm)
                        <form action="{{ route('orders.updateOrder', $order->id) }}" method="POST">
                            @csrf
                            <select name="order_status" id="order_status" class="form-control"
                                    style="width: 300px;margin-bottom: 15px;">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}"
                                            @if(!in_array($status->id, $validStatuses)) disabled @endif
                                        {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->status_name }}
                                    </option>
                                @endforeach
                            </select>
                            <button name="btn_update_order" type="submit" class="btn btn-success">Update</button>
                            <a href="{{route('orders')}}" type="button" class="btn btn-success">Back to</a>
                        </form>
                    @else
                        @if($order->status_id == 4)
                            <p class=" text-success"><b>Order has been delivered.</b></p>
                            <a href="{{route('orders')}}" type="button" class="btn btn-success">Back to</a>
                        @elseif($order->status_id == 5)
                            <p class=" text-danger"><b>Order has been canceled.</b></p>
                            <a href="{{route('orders')}}" type="button" class="btn btn-success">Back to</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

