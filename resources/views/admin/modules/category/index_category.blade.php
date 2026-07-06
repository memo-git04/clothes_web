@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active">Danh mục</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Danh sách danh mục</h4>

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                        @endif

                        <!-- Nested Tree Container -->
                            <div class="nested-tree"
                                 style="margin-left: 100px; margin-right: 100px; overflow-y: auto; border: 1px solid #ced4da; padding: 20px; border-radius: 5px; background: #f8f9fa;">
                                <ul style="list-style-type: none; padding-left: 0; margin-left: 50px; margin-right: 120px">
                                    @foreach($rootCategories as $rootCat)
                                        @include('admin.modules.category.category_view', ['cat' => $rootCat])
                                    @endforeach
                                </ul>
                            </div>

                            <div class="add mt-3">
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Thêm mới danh mục</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
