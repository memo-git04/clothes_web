@extends('admin.dashboard')

@section('content')
    <div class="content-body">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <h3 class="card-title text-white">Products </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">
                                    {{ $data['productsCount'] }}
                                </h2>
                                {{--                                <p class="text-white mb-0">Jan - March 2019</p>--}}
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-shopping-cart"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-2">
                        <div class="card-body">
                            <h3 class="card-title text-white">Net Profit</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">${{$data['totalRevenue']}}</h2>
                                {{--                                <p class="text-white mb-0">Jan - March 2019</p>--}}
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-3">
                        <div class="card-body">
                            <h3 class="card-title text-white">New Customers</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">{{ $data['customersCount'] }} </h2>
                                {{--                                <p class="text-white mb-0">Jan - March 2019</p>--}}
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="card gradient-4">
                        <div class="card-body">
                            <h3 class="card-title text-white">Product is out of stock</h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">
                                    0
                                </h2>

                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa-solid fa-triangle-exclamation"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 20px;">
                <div>
                    <div style="width: 600px; height: 400px; padding: 10px" class="bg-white">
                        <canvas id="myChart" ></canvas>
                        <h4 class="mt-3 text-center">Quantity of  Orders by Status</h4>
                    </div>
                    {{--                {{ json_encode($chartData["labels"])}}--}}
                    <script>
                        const ctx = document.getElementById('myChart');
                        {{--console.log({{$chartData['labels']}});--}}
                        const labelsCate = {!!json_encode($chartData["labels"])!!};
                        const dataCate =  {!!json_encode($chartData['data'])!!};
                        console.log(labelsCate);
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labelsCate,
                                datasets: [{
                                    label: 'Quantity',
                                    data: dataCate,
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    </script>
                </div>
                <div style="width: 766px; height: 400px; padding-left: 20px" class="bg-white">
                    <h4 class="mt-3">Quantity of  Orders by Status</h4>
                    <canvas id="piechart" style="width: 465px; height: 450px;"></canvas>
                    <script type="text/javascript">

                        const chartPie = @json($chart);

                        // Chuyển đổi dữ liệu cho Chart.js
                        const labels = chartPie.map(item => item.label.trim());
                        const data = chartPie.map(item => item.value);

                        const pt = document.getElementById('piechart').getContext('2d');
                        const ordersPieChart = new Chart(pt, {
                            type: 'pie',
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: ['#BBD8F2', '#ADA2F2', '#D9A0BB', '#91D9BF', '#FCF0CF'],
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'right',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Quantity of  Orders by Status'
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <div class="bg-white mt-3" style="width: auto">
                <div style="padding: 15px">
                    <h3>List of products that are about to run out of stock </h3>
                </div>
                <div style="padding: 15px">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- row 1 -->
                        @forelse($products as $product)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$product->product->product_name}}</td>
                                <td>{{$product->product->category->category_name}}</td>
                                <td>{{$product->color->color_name}}</td>
                                <td>{{$product->size->size_name}}</td>
                                <td  class="{{ $product->stock_quantity < 20 ? 'text-danger' : '' }}">
                                    {{$product->stock_quantity}}
                                </td>
                                <td>$ {{ number_format($product->price, 0, ',', '.') }} </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-success">Không có sản phẩm nào sắp hết hàng.</td>
                            </tr>
                        @endforelse
                        <!-- row 2 -->
                        </tbody>
                    </table>
                </div>
                <div class="pagination justify-content-center">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <div class="bg-white mt-3" style="padding: 15px; display: flex">
                <div style="width: 600px">
                    <h3>Top 10 Best Selling Products</h3>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Total Quantity Sold</th>
                            <th>Total Revenue</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topProducts as $index => $product)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->total_quantity }}</td>
                                <td>${{ number_format($product->total_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="width: 600px">
                    <canvas id="BarLineChart"></canvas>
                    <script>
                        fetch('/api/sales/last7days') // API trả về dữ liệu từ backend
                            .then(response => response.json())
                            .then(data => {
                                const labels = data.map(item => item.order_date); // Ngày
                                const quantities = data.map(item => item.total_quantity); // Số lượng
                                const revenues = data.map(item => item.total_revenue); // Doanh thu

                                const sale = document.getElementById('BarLineChart').getContext('2d');
                                const chart = new Chart(sale, {
                                    data: {
                                        labels: labels, // Các ngày trong 7 ngày gần nhất
                                        datasets: [
                                            {
                                                type: 'bar',
                                                label: 'Số lượng',
                                                data: quantities,
                                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                                stack: 'Stack 0'
                                            },
                                            {
                                                type: 'line',
                                                label: 'Doanh thu',
                                                data: revenues,
                                                borderColor: 'rgba(54, 162, 235, 1)',
                                                borderWidth: 2,
                                                fill: false
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: { position: 'top' },
                                            title: { display: true, text: 'Số lượng và Doanh thu (7 ngày gần nhất)' }
                                        },
                                        scales: {
                                            x: { stacked: true }, // Cột x (stacked)
                                            y: { stacked: true }  // Cột y (áp dụng cho bar)
                                        }
                                    }
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    </script>
                </div>
            </div>

        </div>
    </div>



@endsection





