@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Khuyến Mãi</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Chỉnh Sửa </a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chỉnh Sửa Khuyến Mãi</h4>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Mã Khuyến Mãi -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Mã Khuyến Mãi <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                               name="code"
                                               class="form-control @error('code') is-invalid @enderror"
                                               value="{{ old('code', $promotion->code) }}"
                                               required>
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tên Khuyến Mãi -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Tên Khuyến Mãi <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                               name="promotion_name"
                                               class="form-control @error('promotion_name') is-invalid @enderror"
                                               value="{{ old('promotion_name', $promotion->promotion_name) }}"
                                               >

                                    </div>
                                </div>

                                <!-- Mô Tả -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Mô Tả</label>
                                    <div class="col-lg-6">
                                        <textarea name="description"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="4">{{ old('description', $promotion->description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Giá Trị Giảm Giá -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Giá Trị Giảm Giá <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                               name="discount_value"
                                               class="form-control money @error('discount_value') is-invalid @enderror"
                                               value="{{ old('discount_value', $promotion->discount_value) }}"
                                               >

                                    </div>
                                </div>

                                <!-- Số Tiền Tối Thiểu -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Số Tiền Tối Thiểu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                               name="min_order_amount"
                                               class="form-control money @error('min_order_amount') is-invalid @enderror"
                                               value="{{ old('min_order_amount', $promotion->min_order_amount) }}"
                                               >

                                    </div>
                                </div>

                                <!-- Giới Hạn Sử Dụng -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Giới Hạn Sử Dụng <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="number"
                                               name="usage_limit"
                                               class="form-control @error('usage_limit') is-invalid @enderror"
                                               value="{{ old('usage_limit', $promotion->usage_limit) }}"
                                               min="1"
                                               >
                                    </div>
                                </div>

                                <!-- Số Lần Đã Sử Dụng -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Số Lần Đã Sử Dụng
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="form-control-plaintext">
                                            {{ $promotion->current_usage }} / {{ $promotion->usage_limit }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Trạng Thái -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Trạng Thái</label>
                                    <div class="col-lg-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   id="status"
                                                   name="status"
                                                {{ $promotion->is_active === 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                   for="status">
                                                {{ $promotion->is_active === 1 ? 'Kích hoạt (Có hiệu lực)' : 'Vô hiệu hóa' }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ngày Bắt Đầu -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Ngày Bắt Đầu <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local"
                                               name="start_date"
                                               class="form-control @error('start_date') is-invalid @enderror"
                                               value="{{ old('start_date', \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d\TH:i')) }}"
                                               >

                                    </div>
                                </div>

                                <!-- Ngày Kết Thúc -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Ngày Kết Thúc <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local"
                                               name="end_date"
                                               class="form-control @error('end_date') is-invalid @enderror"
                                               value="{{ old('end_date', \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d\TH:i')) }}"
                                               >

                                    </div>
                                </div>

                                <!-- Nút Gửi -->
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Cập Nhật Khuyến Mãi
                                        </button>
                                        <a href="{{ route('admin.promotions.index') }}"
                                           class="btn btn-secondary ml-2">
                                            <i class="fas fa-arrow-left"></i> Quay Lại
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        .money {
            position: relative;
        }
        .money::before {
            content: '₫';
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .money:focus {
            padding-left: 30px;
        }
        .form-control-plaintext {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
            margin-bottom: 0;
            background-color: transparent;
            border: none;
        }
    </style>


@endsection
