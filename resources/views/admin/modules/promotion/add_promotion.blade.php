@extends('admin.layouts.dashboard')
@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Promotion</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add New Promotion</h4>

                            <form action="{{ route('promotions.store') }}" method="POST">
                            @csrf

                            <!-- Code -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Code</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="code" class="form-control">
                                    </div>
                                </div>

                                <!-- Promotion Name -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Promotion Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="promotion_name" class="form-control">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Description</label>
                                    <div class="col-lg-6">
                                        <textarea name="description" class="form-control"></textarea>
                                    </div>
                                </div>

                                <!-- Discount Type -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Discount Type</label>
                                    <div class="col-lg-6">
                                        <select name="discount_type" class="form-control">
                                            <option value="percent">Percent (%)</option>
                                            <option value="fixed">Fixed Amount</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Discount Value -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Discount Value</label>
                                    <div class="col-lg-6">
                                        <input type="number" step="0.01" name="discount_value" class="form-control">
                                    </div>
                                </div>

                                <!-- Usage Limit -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Usage Limit</label>
                                    <div class="col-lg-6">
                                        <input type="number" name="usage_limit" class="form-control">
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Start Date</label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local" name="start_date" class="form-control">
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">End Date</label>
                                    <div class="col-lg-6">
                                        <input type="datetime-local" name="end_date" class="form-control">
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Add Promotion</button>
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
