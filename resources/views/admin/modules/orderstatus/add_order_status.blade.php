@extends('admin.dashboard')
@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Order Status</h4>

                            <form action="{{ route('admin.order-status.store') }}" method="POST">
                                @csrf

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Status Name</label>
                                    <div class="col-lg-6">
                                        <input type="text" name="status_name" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Add new</button>
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
