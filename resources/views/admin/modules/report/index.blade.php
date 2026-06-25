@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="container-fluid mt-3">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">

                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Tổng Sản Phẩm</h3>
                            <h2 class="text-white">{{ $totalProducts }}</h2>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Doanh Thu Tháng</h3>
                            <h2 class="text-white">{{ number_format($monthlyRevenue, 0, ',', '.') }}đ</h2>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">Khách Mới</h3>
                            <h2 class="text-white">{{ $newCustomers }}</h2>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">Sắp Hết Hàng</h3>
                            <h2 class="text-white">{{ $lowStockCount }}</h2>
                            <span class="float-right display-5 opacity-5"><i class="fa-solid fa-triangle-exclamation"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row mt-4">
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <h4>Doanh thu 6 tháng gần nhất</h4>
                            <canvas id="revenueChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <h4>Đơn hàng theo trạng thái</h4>
                            <canvas id="piechart" height="180"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm sắp hết hàng -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Sản phẩm sắp hết hàng (≤ 10)</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Màu</th>
                            <th>Size</th>
                            <th>Tồn kho</th>
                            <th>Giá</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lowStockProducts as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>{{ $variant->product->product_name }}</td>
                                <td>{{ $variant->product->category->category_name ?? 'N/A' }}</td>
                                <td>{{ $variant->color->color_name ?? 'N/A' }}</td>
                                <td>{{ $variant->size->size_name ?? 'N/A' }}</td>
                                <td class="text-danger font-weight-bold">{{ $variant->stock_quantity }}</td>
                                <td>{{ number_format($variant->price, 0, ',', '.') }}đ</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-success">Không có sản phẩm nào sắp hết hàng.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $lowStockProducts->links() }}
                </div>
            </div>

            <!-- Top bán chạy -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Top 10 Sản Phẩm Bán Chạy Tháng Này</h3>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng bán</th>
                            <th>Doanh thu</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topProducts as $index => $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->product_name }}</td>
                                <td>{{ $p->total_quantity }}</td>
                                <td>{{ number_format($p->total_revenue, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Revenue Line Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($revenueData) !!},
                    borderColor: '#4CAF50',
                    tension: 0.3
                }]
            },
            options: { responsive: true }
        });

        // Pie Chart - Orders by Status
        const pieData = {!! $chartData->toJson() !!};
        new Chart(document.getElementById('piechart'), {
            type: 'pie',
            data: {
                labels: pieData.map(i => i.label),
                datasets: [{
                    data: pieData.map(i => i.value),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            }
        });
    </script>
@endsection
