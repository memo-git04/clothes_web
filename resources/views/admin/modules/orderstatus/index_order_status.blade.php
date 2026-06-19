@extends('admin.dashboard')
@section('content')

    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order Status List</h4>

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Status Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach( $orderStatuses as $status)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm">
                                                {{ $status->status_name }}
                                            </button>
                                        </td>
                                        <td>
                                            <form action="" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <a href="{{ route('admin.order-status.create') }}" class="btn btn-success mt-2">
                                Add new status
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
