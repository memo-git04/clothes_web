@extends('admin.dashboard')   {{-- thay bằng layout admin của bạn --}}

@section('content')
    <div class="content-body">
        <div class="container-fluid mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-lock fa-6x text-danger mb-4"></i>
                            <h2 class="text-danger">403 - Truy cập bị từ chối</h2>

                            <p class="lead mt-3">
                                {{ $message ?? 'Bạn không có quyền thực hiện chức năng này.' }}
                            </p>

                            <div class="mt-4">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                    <i class="fas fa-home"></i> Quay về Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
