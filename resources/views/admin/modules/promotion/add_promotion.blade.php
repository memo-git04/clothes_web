@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Thêm Khuyến Mãi</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thêm Khuyến Mãi Mới</h4>

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

                            <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Mã Khuyến Mãi -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">
                                        Mã Khuyến Mãi <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input type="text"
                                               name="code"
                                               value="{{ old('code') }}"
                                               class="form-control @error('code') is-invalid @enderror"
                                               >
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
                                               value="{{ old('promotion_name') }}"
                                               class="form-control @error('promotion_name') is-invalid @enderror"
                                               >
                                    </div>
                                </div>

                                <!-- Mô Tả -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Mô Tả</label>
                                    <div class="col-lg-6">
                                        <textarea name="description"
                                                  value="{{ old('description') }}"
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="4"></textarea>

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
                                               value="{{ old('discount_value') }}"
                                               class="form-control money @error('discount_value') is-invalid @enderror"
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
                                               value="{{ old('min_order_amount') }}"
                                               class="form-control money @error('min_order_amount') is-invalid @enderror"
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
                                               value="{{ old('usage_limit') }}"
                                               class="form-control @error('usage_limit') is-invalid @enderror"
                                               min="1"
                                               >

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
                                               value="{{ old('start_date') }}"
                                               class="form-control @error('start_date') is-invalid @enderror"
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
                                               value="{{ old('end_date') }}"
                                               class="form-control @error('end_date') is-invalid @enderror"
                                               >

                                    </div>
                                </div>

                                <!-- Nút Gửi -->
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Thêm Khuyến Mãi
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
    </style>

    <script>
        // Format money input
        document.querySelectorAll('.money').forEach(input => {
            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                this.value = new Intl.NumberFormat('vi-VN').format(value);
            });
        });

        // Set minimum date to today
        document.querySelectorAll('input[type="datetime-local"]').forEach(input => {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const minDate = `${year}-${month}-${day}T${hours}:${minutes}`;
            input.min = minDate;
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const startDate = new Date(document.querySelector('input[name="start_date"]').value);
            const endDate = new Date(document.querySelector('input[name="end_date"]').value);

            if (endDate <= startDate) {
                e.preventDefault();
                alert('Ngày kết thúc phải sau ngày bắt đầu');
                return;
            }

            const discountValue = parseInt(document.querySelector('input[name="discount_value"]').value.replace(/\D/g, ''));
            const minOrderAmount = parseInt(document.querySelector('input[name="min_order_amount"]').value.replace(/\D/g, ''));

            if (discountValue >= minOrderAmount) {
                e.preventDefault();
                alert('Giá trị giảm giá phải nhỏ hơn số tiền tối thiểu');
                return;
            }
        });
    </script>
@endsection
