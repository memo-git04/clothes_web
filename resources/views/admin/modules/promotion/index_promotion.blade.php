@extends('admin.dashboard')
@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Mã Giảm Giá</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h4 class="card-title">Danh sách mã giảm giá</h4>
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã giảm giá</th>
                                        <th>Mô tả</th>
                                        <th>Giới hạn sử dụng</th>
                                        <th>Đã sử dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($promotions as $key => $promotion)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>

                                            <td>
                                                <strong>{{ $promotion->code }}</strong>
                                            </td>

                                            <td>
                                                {{ $promotion->description }}
                                            </td>

                                            <td>
                                                {{ $promotion->usage_limit }}
                                            </td>

                                            <td>
                                                {{ $promotion->current_usage }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($promotion->start_date)->format('d-m-Y H:i') }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($promotion->end_date)->format('d-m-Y H:i') }}
                                            </td>

                                            <td class="d-flex">

                                                <!-- Edit -->
                                                <a href="{{ route('admin.promotions.edit', $promotion->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm mr-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('admin.promotions.destroy', $promotion->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Bạn có chắc chắn muốn xóa mã giảm giá này không?')">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                    <tfoot>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã giảm giá</th>
                                        <th>Mô tả</th>
                                        <th>Giới hạn sử dụng</th>
                                        <th>Đã sử dụng</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Add button -->
                            <div class="add mt-2 mx-4">
                                <a href="{{ route('admin.promotions.create') }}">
                                    <button type="button" class="btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Thêm mã giảm giá mới
                                    </button>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
