<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductVariant;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with([
            'user',
            'status',
            'orderItems.variant.product'
        ])
            ->latest()
            ->get();
        return view('admin.modules.orders.order',[
            'orders' => $orders,
        ]);
    }
    public function filterOrder($status_id)
    {
        $orders = Order::with(['user', 'status', 'orderItems.variant.product'])
            ->where('status_id', $status_id)
            ->latest()
            ->get();
        return view('admin.modules.orders.order', [
            'orders' => $orders,
        ]);
    }


    public function orderHistory(){
        $orders = Order::with([
            'status',
            'orderItems.variant.product',
            'orderItems.variant'
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('order_history',[
            'orders' => $orders,
        ]);
    }
    public function filter($status_id)
    {
        $orders = Order::with(['orderItems.variant.product', 'status'])
            ->where('user_id', auth()->id())
            ->where('status_id', $status_id)
            ->latest()
            ->paginate(10);
        return view('order_history',[
            'orders' => $orders,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        // Chỉ chủ đơn mới được xem chi tiết (tránh xem đơn tài khoản khác qua ID)
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['orderItems.variant.product',
            'orderItems.variant.images',
            'orderItems.variant.size',
            'orderItems.variant.color',
            'orderItems.review',
            'payment',
            'status']);
        // Nếu đơn hàng đã giao thành công (status_id = 4), cập nhật trạng thái thanh toán thành 'paid'
        if ($order->status_id == 4 && $order->payment->status != 'paid') {
            $order->payment->update(['status' => 'paid']);
        }
        return view('order_item', compact('order'));
    }

    public function cancel(Order $order)
    {
        // Chỉ chủ đơn mới được hủy
        abort_unless($order->user_id === auth()->id(), 403);

        if ($order->status_id !== Order::STATUS_PENDING) {
            return redirect()->back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái Chờ xác nhận!');
        }

        DB::transaction(function () use ($order) {
            // Hoàn lại tồn kho
            foreach ($order->orderItems as $item) {
                ProductVariant::where('id', $item->product_variant_id)
                    ->increment('stock_quantity', $item->quantity);
            }
            // Hoàn lại lượt dùng mã giảm giá (nếu có)
            if ($order->promotion_id) {
                \App\Models\Promotion::where('id', $order->promotion_id)
                    ->where('current_usage', '>', 0)
                    ->decrement('current_usage');
            }
            $order->update(['status_id' => Order::STATUS_CANCELLED]);
        });

        return redirect()->route('orderHistory')
            ->with('success', 'Đơn hàng đã được hủy thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
