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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product List </h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Base Price</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Act</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
{{--                                            <td>{{$loop->iteration}}</td>--}}
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->product_name}}</td>
                                            <td> {{number_format($product->base_price, 2, ',', '.') }} VND</td>
                                            <td>{{$product->brand->brand_name}}</td>
                                            <td>{{$product->category->category_name}}</td>

                                            <td>
                                                <a href="{{route('products.edit',$product->id )}}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i></button></a>
                                                <a href="{{route('products.show',$product->id )}}"><button type="button" class="btn btn-primary btn-sm"><i class="fa-solid fa-eye"></i></button></a>
                                                <form action="{{route('products.destroy',$product->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" name="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Base Price</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Act</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="add mt-2 mx-4">
                            <a href="{{route('products.create')}}"><button type="button" class="btn btn-success"><i class="fa-solid fa-plus"></i> Add new</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
