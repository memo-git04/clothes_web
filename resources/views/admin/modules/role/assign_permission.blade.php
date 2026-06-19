@extends('admin.dashboard')

@section('content')

    <div class="content-body">
        <div class="container-fluid">

            ```
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">
                        Gán Permission cho Role: {{ $role->name }}
                    </h4>

                    <form method="POST" action="{{ route('admin.roles.permissions.update', $role->id) }}">
                        @csrf

{{--                        --}}{{-- Role --}}
{{--                        <div class="mb-4">--}}
{{--                            <label>Role:</label>--}}
{{--                            <input type="text" class="form-control" value="{{ $role->name }}" disabled>--}}
{{--                        </div>--}}

                        {{-- Matrix --}}
                        @foreach($permissions as $module => $perms)
                            <div class="mb-4">

                                <h5 class="bg-light p-2">
                                    {{ strtoupper($module) }}
                                </h5>

                                <table class="table table-bordered text-center">
                                    <thead>
                                    <tr>
                                        @foreach($perms as $perm)
                                            <th>
                                                @php
                                                    $parts = explode('.', $perm->name);
                                                @endphp

                                                {{ ucfirst($parts[1] ?? $parts[0]) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        @foreach($perms as $perm)
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $perm->name }}"
                                                    {{ $role->permissions->pluck('name')->contains($perm->name) ? 'checked' : '' }}
                                                >
                                            </td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        @endforeach

                        <button class="btn btn-primary">
                            Lưu
                        </button>

                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                            Quay lại
                        </a>

                    </form>

                </div>
            </div>

        </div>
        ```

    </div>
@endsection
