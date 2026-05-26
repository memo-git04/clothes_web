@extends('admin.layouts.dashboard')

@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Promotion</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Promotion</h4>

                            <form action="{{ route('promotions.update', $promotion->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Code -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Code</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="code" class="form-control"
                                               value="{{ old('code', $promotion->code) }}">
                                    </div>
                                </div>

                                <!-- Promotion Name -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Promotion Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="promotion_name" class="form-control"
                                               value="{{ old('promotion_name', $promotion->promotion_name) }}">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Description</label>
                                    <div class="col-lg-6">
                                        <textarea name="description" class="form-control">{{ old('description', $promotion->description) }}</textarea>
                                    </div>
                                </div>

                                <!-- Discount Type -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Discount Type</label>
                                    <div class="col-lg-6">
                                        <select name="discount_type" class="form-control">
                                            <option value="percent" {{ $promotion->discount_type == 'percent' ? 'selected' : '' }}>Percent (%)</option>
                                            <option value="fixed" {{ $promotion->discount_type == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Discount Value</label>
                                    <div class="col-lg-6">
                                        <input type="number" step="0.01" name="discount_value" class="form-control"
                                               value="{{ old('discount_value', $promotion->discount_value) }}">
                                    </div>
                                </div>

                                <!-- Usage Limit -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Usage Limit</label>
                                    <div class="col-lg-6">
                                        <input type="number" name="usage_limit" class="form-control"
                                               value="{{ old('usage_limit', $promotion->usage_limit) }}">
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Start Date</label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local" name="start_date" class="form-control"
                                               value="{{ old('start_date', \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d\TH:i')) }}">
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">End Date</label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local" name="end_date" class="form-control"
                                               value="{{ old('end_date', \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d\TH:i')) }}">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Update Promotion</button>
                                        <a href="{{ route('promotions.index') }}" class="btn btn-success">Back</a>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
