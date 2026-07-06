@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="container-fluid mt-3">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Summary cards -->
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
                            <h3 class="card-title text-white">Đánh giá mới (Chờ duyệt)</h3>
                            <h2 class="text-white">{{ $pendingReviews }}</h2>
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
            <div class="row mt-2">
                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <h4 class="mb-0">Doanh thu <small class="text-muted"></small></h4>
                                <div class="form-inline">
                                    <select id="granularity" class="form-control form-control-sm mr-2">
                                        <option value="day">Theo ngày</option>
                                        <option value="month" selected>Theo tháng</option>
                                        <option value="year">Theo năm</option>
                                    </select>
                                    <select id="yearSelect" class="form-control form-control-sm mr-2">
                                        @foreach($years as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                    <select id="monthSelect" class="form-control form-control-sm" style="display:none;">
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>Tháng {{ $m }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <p class="mb-2">Tổng: <strong id="revenueTotal" class="text-success"></strong></p>
                            <canvas id="revenueChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body">
                            <h4>Đơn hàng theo trạng thái <small class="text-muted">(bấm để lọc)</small></h4>
                            <canvas id="piechart" ></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail panel: loaded when a chart is clicked -->
            <div class="card mt-2" id="detailCard" style="display:none;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0" id="detailTitle">Danh sách đơn hàng</h3>
                    <button class="btn btn-sm btn-secondary" onclick="document.getElementById('detailCard').style.display='none'">Đóng</button>
                </div>
                <div class="card-body">
                    <div id="detailLoading" class="text-center text-muted" style="display:none;">Đang tải...</div>
                    <table class="table table-sm table-hover">
                        <thead>
                        <tr><th>Mã đơn</th><th>Khách hàng</th><th>Ngày</th><th>Tổng tiền</th><th>Trạng thái</th></tr>
                        </thead>
                        <tbody id="detailBody"></tbody>
                    </table>
                </div>
            </div>

            <!-- Đơn hàng ưu tiên xử lý -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Đơn hàng chờ xử lý <small class="text-muted">(Chờ xác nhận)</small></h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($pendingOrders as $order)
                            <tr class="{{ $order->status_id == 1 ? 'table-warning' : '' }}">
                                <td>#{{ $order->order_code }}</td>
                                <td>{{ $order->user->full_name ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->final_amount, 0, ',', '.') }}đ</td>
                                <td><span class="badge badge-info">{{ $order->status->status_name }}</span></td>
                                <td>
                                    <a href="{{ route('admin.orders.items', $order->id)}}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-success">Không có đơn nào cần xử lý.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sản phẩm sắp hết hàng -->
            <div class="card mt-4">
                <div class="card-header"><h3>Sản phẩm sắp hết hàng</h3></div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr><th>#</th><th>Sản phẩm</th><th>Danh mục</th><th>Màu</th><th>Size</th><th>Tồn kho</th>
                            <th>Giá</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($lowStockProducts as $variant)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $variant->product->product_name }}</td>
                                <td>{{ $variant->product->category->category_name ?? 'N/A' }}</td>
                                <td>{{ $variant->color->color_name ?? 'N/A' }}</td>
                                <td>{{ $variant->size->size_name ?? 'N/A' }}</td>
                                <td class="text-danger font-weight-bold">{{ $variant->stock_quantity }}</td>
                                <td>{{ number_format($variant->selling_price, 0, ',', '.') }}đ</td>
                                <td>
                                    <a href="{{route('admin.products.show',$variant->product->id )}}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
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
                <div class="card-header"><h3>Top 10 Sản Phẩm Bán Chạy Tháng Này</h3></div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr><th>#</th><th>Sản phẩm</th><th>Số lượng bán</th><th>Doanh thu</th></tr>
                        </thead>
                        <tbody>
                        @forelse($topProducts as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->product_name }}</td>
                                <td>{{ $p->total_quantity }}</td>
                                <td>{{ number_format($p->total_revenue, 0, ',', '.') }}đ</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">Chưa có dữ liệu.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ROUTES = {
            revenue: "{{ route('admin.reports.revenue') }}",
            orders:  "{{ route('admin.reports.orders') }}",
        };

        const fmtVND = v => Number(v).toLocaleString('vi-VN') + 'đ';

        // ===== Revenue chart =====
        let revenueChart;
        const state = {
            granularity: 'month',
            year: {{ (int) now()->year }},
            month: {{ (int) now()->month }},
            labels: @json($revenueLabels),
            data: @json($revenueData),
        };

        function renderRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (revenueChart) revenueChart.destroy();
            revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: state.labels,
                    datasets: [{ label: 'Doanh thu', data: state.data, backgroundColor: '#4CAF50' }]
                },
                options: {
                    responsive: true,
                    onClick: (e, els) => {
                        if (!els.length) return;
                        const i = els[0].index;
                        onRevenueBarClick(i);
                    },
                    plugins: { legend: { display: false } }
                }
            });
            document.getElementById('revenueTotal').textContent =
                fmtVND(state.data.reduce((a, b) => a + Number(b), 0));
        }

        function onRevenueBarClick(i) {
            const params = {};
            let title = '';
            if (state.granularity === 'day') {
                params.year = state.year; params.month = state.month; params.day = i + 1;
                title = `Đơn ngày ${i + 1}/${state.month}/${state.year}`;
            } else if (state.granularity === 'year') {
                params.year = (state.year - 4) + i;
                title = `Đơn năm ${params.year}`;
            } else {
                params.year = state.year; params.month = i + 1;
                title = `Đơn tháng ${i + 1}/${state.year}`;
            }
            loadOrders(params, title);
        }

        async function loadRevenue() {
            state.granularity = document.getElementById('granularity').value;
            state.year = parseInt(document.getElementById('yearSelect').value);
            state.month = parseInt(document.getElementById('monthSelect').value);
            document.getElementById('monthSelect').style.display =
                state.granularity === 'day' ? 'inline-block' : 'none';

            const url = `${ROUTES.revenue}?granularity=${state.granularity}&year=${state.year}&month=${state.month}`;
            const res = await fetch(url);
            const json = await res.json();
            state.labels = json.labels;
            state.data = json.data;
            renderRevenueChart();
        }

        document.getElementById('granularity').addEventListener('change', loadRevenue);
        document.getElementById('yearSelect').addEventListener('change', loadRevenue);
        document.getElementById('monthSelect').addEventListener('change', loadRevenue);
        renderRevenueChart();

        // ===== Pie: orders by status =====
        const pieData = @json($chartData);
        new Chart(document.getElementById('piechart'), {
            type: 'pie',
            data: {
                labels: pieData.map(i => i.label),
                datasets: [{
                    data: pieData.map(i => i.value),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#8E44AD']
                }]
            },
            options: {
                onClick: (e, els) => {
                    if (!els.length) return;
                    const row = pieData[els[0].index];
                    loadOrders({ status_id: row.status_id }, `Đơn: ${row.label}`);
                }
            }
        });

        // ===== Load orders into detail panel =====
        async function loadOrders(params, title) {
            const card = document.getElementById('detailCard');
            const body = document.getElementById('detailBody');
            const loading = document.getElementById('detailLoading');
            document.getElementById('detailTitle').textContent = title;
            card.style.display = 'block';
            loading.style.display = 'block';
            body.innerHTML = '';

            const qs = new URLSearchParams(params).toString();
            const res = await fetch(`${ROUTES.orders}?${qs}`);
            const json = await res.json();
            loading.style.display = 'none';

            if (!json.orders.length) {
                body.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Không có đơn hàng nào.</td></tr>';
                return;
            }
            body.innerHTML = json.orders.map(o => `
                <tr>
                    <td>#${o.order_code}</td>
                    <td>${o.customer}</td>
                    <td>${o.date}</td>
                    <td>${o.total}</td>
                    <td><span class="badge badge-info">${o.status}</span></td>
                </tr>`).join('');
            card.scrollIntoView({ behavior: 'smooth' });
        }
    </script>
@endsection
