@extends('admin.dashboard')
@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Promotions</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <h4 class="card-title">List of Promotions</h4>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Usage Limit</th>
                                        <th>Current Usage</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Act</th>
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
                                                <a href="{{ route('promotions.edit', $promotion->id) }}">
                                                    <button type="button" class="btn btn-primary btn-sm mr-1">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                </a>

                                                <!-- Delete -->
                                                <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
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
                                        <th>Code</th>
                                        <th>Description</th>
                                        <th>Usage Limit</th>
                                        <th>Current Usage</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Act</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Add button -->
                            <div class="add mt-2 mx-4">
                                <a href="{{ route('admin.promotions.create') }}">
                                    <button type="button" class="btn btn-success">
                                        <i class="fa-solid fa-plus"></i> Add new promotion
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
