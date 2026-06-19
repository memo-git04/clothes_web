@extends('admin.dashboard')
@section('content')
@can('user.test')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Trang chủ</a></li>
                </ol>
            </div>
        </div>
    <!-- row -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Danh sách sản phẩm </h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá bán</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    @php
                                                        $variant = $product->variants->first();
                                                        $image = optional(optional($variant)->firstImg)->image_url;
                                                    @endphp
                                                    <img src="{{ $image ? asset('storage/'.$image) : asset('images/no-image.png') }}" width="60">
                                                </td>
                                                <td>{{$product->product_name}}</td>
                                                <td>
                                                    @if($variant)
                                                        {{ number_format($variant->selling_price, 0, ',', '.') }} VND
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>{{$product->category->category_name}}</td>
                                                <td>
                                                    @switch($product->stock_status)
                                                        @case('inactive')
                                                        <span class="badge badge-secondary">Tạm ngưng bán</span>
                                                        @break

                                                        @case('out_of_stock')
                                                        <span class="badge badge-danger">Hết hàng</span>
                                                        @break

                                                        @case('low_stock')
                                                        <span class="badge badge-warning">Sắp hết</span>
                                                        @break

                                                        @default
                                                        <span class="badge badge-success">Còn hàng</span>
                                                    @endswitch
                                                </td>
                                                <td>
                                                    <a href="{{route('admin.products.show',$product->id )}}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button></a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá bán</th>
                                            <th>Danh mục</th>
                                            <th>Trạng thái</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="add mt-2 mx-4">
                                <a href="{{route('admin.products.create')}}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add new</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
