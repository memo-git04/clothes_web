<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Thống kê nhanh
        $totalProducts     = Product::count();
        $monthlyRevenue    = Order::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->whereHas('status', fn($q) => $q->where('status_name', '!=', 'Hủy'))
            ->sum('final_amount');

        $newCustomers      = User::whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $lowStockCount     = ProductVariant::where('stock_quantity', '<=', 10)->count();

        // Top sản phẩm bán chạy
        $topProducts = Order::selectRaw('products.product_name,
            SUM(order_items.quantity) as total_quantity,
            SUM(order_items.quantity * order_items.price) as total_revenue')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->whereHas('status', fn($q) => $q->where('status_name', '!=', 'Hủy'))
            ->whereYear('orders.created_at', $now->year)
            ->whereMonth('orders.created_at', $now->month)
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        // Sản phẩm sắp hết hàng
        $lowStockProducts = ProductVariant::with(['product.category', 'color', 'size'])
            ->where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->paginate(10);

        // Doanh thu 6 tháng
        $revenueData = [];
        $revenueLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $revenueLabels[] = $date->format('M Y');

            $revenue = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->whereHas('status', fn($q) => $q->where('status_name', '!=', 'Hủy'))
                ->sum('final_amount');

            $revenueData[] = $revenue ?? 0;
        }

        // Đơn hàng gần đây (ưu tiên trạng thái đang xử lý)
        $recentOrders = Order::with(['user', 'status'])
            ->join('order_statuses', 'orders.status_id', '=', 'order_statuses.id')
            ->select('orders.*', 'order_statuses.status_name')
            ->orderByRaw("FIELD(order_statuses.status_name, 'Chờ xác nhận', 'Chờ lấy hàng', 'Đang lấy hàng', 'Đang vận chuyển', 'Giao thành công', 'Hủy')")
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        // Chart: Đơn hàng theo trạng thái
        $chartData = Order::selectRaw('order_statuses.status_name as label, COUNT(*) as value')
            ->join('order_statuses', 'orders.status_id', '=', 'order_statuses.id')
            ->groupBy('order_statuses.status_name')
            ->get();

        return view('admin.modules.report.index', compact(
            'totalProducts', 'monthlyRevenue', 'newCustomers', 'lowStockCount',
            'topProducts', 'lowStockProducts', 'revenueData', 'revenueLabels',
            'recentOrders', 'chartData'
        ));
    }

}
