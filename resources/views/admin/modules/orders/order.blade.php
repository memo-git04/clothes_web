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
            <!-- Page Heading -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order List</h4>
                            <div class="table-responsive">

                                <div class="mb-3">
                                    <td>
                                        <a href="{{ route('orders.filterOrder', 4) }}"><button type="button" class="btn btn-warning btn-sm">Order has been completed</button></a>
                                        <a href="{{ route('orders.filterOrder', 1) }}"><button type="button" class="btn btn-success btn-sm">Order pending confirmation</button></a>
                                        <a href="{{ route('orders.filterOrder', 5) }}"><button type="button" class="btn btn-danger btn-sm">Order has been cancelled</button></a>
                                    </td>
                                </div>
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Total order</th>
                                            <th>Order date</th>
                                            <th>Status</th>
                                            <th>Act</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            @foreach($order->orderItems as $item)
{{--                                                {{dd($item)}}--}}
                                                <tr>
                                                    <td>{{$loop->parent->iteration}}</td>
                                                    <td>{{ $item->productVariant->product->product_name}}</td>
                                                    <td>$ {{ number_format($order->total_amount, 2) }}</td>
                                                    <td>{{ $order->order_date }}</td>
                                                    <td>
                                                        <span class="text text-primary">
                                                             {{ $order->status->status_name }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('orders.items', $order->id)}}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button></a>
                                                        <a href="{{route('orders.items', $order->id)}}"><button type="button" class="btn btn-warning btn-sm"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                        <a href="">
                                                            <form action="{{ route('orders.delete', $order->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                            </form>
                                                        </a>
                                                    </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Total order</th>
                                            <th>Order date</th>
                                            <th>Status</th>
                                            <th>Act</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
                Content body end
            ***********************************-->
@endsection
