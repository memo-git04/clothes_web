<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // ==== Thống kê nhanh ====
        $totalProducts  = Product::count();
        $monthlyRevenue = Order::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->where('status_id', '!=', Order::STATUS_CANCELLED)
            ->sum('final_amount');

        $lowStockCount = ProductVariant::where('stock_quantity', '<=', 10)->count();

        // ==== Top sản phẩm bán chạy (tháng này) ====
        $topProducts = $this->topProductsQuery($now->year, $now->month)->limit(10)->get();

        // ==== Sản phẩm sắp hết hàng ====
        $lowStockProducts = ProductVariant::with(['product.category', 'color', 'size'])
            ->where('stock_quantity', '<=', 10)
            ->orderBy('stock_quantity', 'asc')
            ->paginate(10);

        // ==== Doanh thu mặc định: 12 tháng của năm hiện tại ====
        [$revenueLabels, $revenueData] = $this->revenueSeries('month', $now->year, $now->month);

        // ==== Đơn hàng theo trạng thái (pie) ====
        $chartData = Order::selectRaw('order_statuses.id as status_id, order_statuses.status_name as label, COUNT(*) as value')
            ->join('order_statuses', 'orders.status_id', '=', 'order_statuses.id')
            ->groupBy('order_statuses.id', 'order_statuses.status_name')
            ->get();

        // ==== Đơn hàng ưu tiên xử lý: chờ duyệt lên đầu, rồi cũ nhất trước ====
        $pendingOrders = Order::with(['user', 'status'])
            ->whereIn('status_id', [
                Order::STATUS_PENDING,
                Order::STATUS_PACKING,
                Order::STATUS_SHIPPING,
            ])
            ->orderByRaw('CASE WHEN status_id = ' . Order::STATUS_PENDING . ' THEN 0 ELSE 1 END')
            ->orderBy('created_at', 'asc') // tt cũ nhất lên đầu
            ->limit(15)
            ->get();

        $years = range($now->year, $now->year - 4);

        return view('admin.modules.report.index', compact(
            'totalProducts', 'monthlyRevenue', 'lowStockCount',
            'topProducts', 'lowStockProducts', 'revenueData', 'revenueLabels',
            'pendingOrders', 'chartData', 'years'
        ));
    }

    /**
     * AJAX: dữ liệu doanh thu theo granularity (day|month|year).
     */
    public function revenue(Request $request)
    {
        $granularity = $request->input('granularity', 'month');
        $year  = (int) $request->input('year', now()->year);
        $month = (int) $request->input('month', now()->month);

        [$labels, $data] = $this->revenueSeries($granularity, $year, $month);

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'total'  => array_sum($data),
        ]);
    }

    /**
     * AJAX: danh sách đơn hàng khi bấm vào biểu đồ.
     * Lọc theo status_id HOẶC theo khoảng thời gian (year/month/day).
     */
    public function ordersList(Request $request)
    {
        $query = Order::with(['user', 'status'])->latest();

        if ($request->filled('status_id')) {
            $query->where('status_id', (int) $request->status_id);
        } else {
            // Danh sách theo doanh thu -> loại đơn đã hủy
            $query->where('status_id', '!=', Order::STATUS_CANCELLED);
        }

        if ($request->filled('year'))  $query->whereYear('created_at', (int) $request->year);
        if ($request->filled('month')) $query->whereMonth('created_at', (int) $request->month);
        if ($request->filled('day'))   $query->whereDay('created_at', (int) $request->day);

        $orders = $query->limit(100)->get()->map(fn($o) => [
            'order_code' => $o->order_code,
            'customer'   => $o->user->full_name ?? ($o->user->user_name ?? 'Khách vãng lai'),
            'date'       => $o->created_at->format('d/m/Y H:i'),
            'total'      => number_format($o->final_amount, 0, ',', '.') . 'đ',
            'status'     => $o->status->status_name ?? '',
        ]);

        return response()->json([
            'count'  => $orders->count(),
            'orders' => $orders,
        ]);
    }

    /**
     * AJAX: top sản phẩm bán chạy theo khoảng thời gian.
     */
    public function topProductsList(Request $request)
    {
        $year  = $request->filled('year') ? (int) $request->year : null;
        $month = $request->filled('month') ? (int) $request->month : null;

        $products = $this->topProductsQuery($year, $month)->limit(10)->get()->map(fn($p) => [
            'name'     => $p->product_name,
            'quantity' => (int) $p->total_quantity,
            'revenue'  => number_format($p->total_revenue, 0, ',', '.') . 'đ',
        ]);

        return response()->json(['products' => $products]);
    }

    // ==================== Helpers ====================

    /**
     * Sinh chuỗi doanh thu theo granularity.
     * @return array [labels[], data[]]
     */
    private function revenueSeries(string $granularity, int $year, int $month): array
    {
        $labels = [];
        $data   = [];

        $base = Order::where('status_id', '!=', Order::STATUS_CANCELLED);

        if ($granularity === 'day') {
            // Theo ngày trong 1 tháng
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $labels[] = $d;
                $data[]   = (float) (clone $base)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month)
                    ->whereDay('created_at', $d)
                    ->sum('final_amount');
            }
        } elseif ($granularity === 'year') {
            // 5 năm gần nhất
            for ($y = $year - 4; $y <= $year; $y++) {
                $labels[] = (string) $y;
                $data[]   = (float) (clone $base)
                    ->whereYear('created_at', $y)
                    ->sum('final_amount');
            }
        } else {
            // Mặc định: 12 tháng của năm
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = 'Th' . $m;
                $data[]   = (float) (clone $base)
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $m)
                    ->sum('final_amount');
            }
        }

        return [$labels, $data];
    }

    /**
     * Query top sản phẩm bán chạy (bỏ đơn đã hủy). year/month có thể null = toàn thời gian.
     */
    private function topProductsQuery(?int $year, ?int $month)
    {
        $q = Order::selectRaw('products.product_name,
                SUM(order_items.quantity) as total_quantity,
                SUM(order_items.quantity * order_items.price) as total_revenue')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->where('orders.status_id', '!=', Order::STATUS_CANCELLED)
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total_quantity');

        if ($year)  $q->whereYear('orders.created_at', $year);
        if ($month) $q->whereMonth('orders.created_at', $month);

        return $q;
    }
}
