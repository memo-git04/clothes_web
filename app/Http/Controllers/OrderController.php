<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

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
            'orderItems.variant.product'
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
        $order->load(['orderItems.variant.product',
            'orderItems.variant.images',
            'status']);
        return view('order_item', compact('order'));
    }

    public function cancel(Order $order)
    {
        if ($order->status_id !== 1) {
            return redirect()->back()->with('error', 'Chỉ có thể hủy đơn hàng ở trạng thái Chờ xác nhận!');
        }

        $order->update(['status_id' => 6]); // Hủy đơn

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
