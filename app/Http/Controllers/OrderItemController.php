<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Request;

class OrderItemController extends Controller
{
    public function showItems($id)
    {
        $order = Order::with([
            'orderItems.variant.product',
            'orderItems.variant.images',
            'status',
            'user'
        ])->findOrFail($id);

        $statuses = OrderStatus::all();
        $current = $order->status_id;
        // Trạng thái hợp lệ để update (theo logic của bạn)
        $validStatuses = [1, 2, 3, 4, 5,6]; // Chờ xác nhận, Đang lấy hàng, Đang vận chuyển, Giao thành công

        $showUpdateForm = in_array($current, [1,2,3,4]);// Không cho update nếu đã hoàn thành hoặc hủy

        return view('admin.modules.orders.order_detail', [
            'order' => $order,
            'statuses' => $statuses,
            'validStatuses' => $validStatuses,
            'showUpdateForm' => $showUpdateForm,
        ]);
    }
    public function updateOrder(\Illuminate\Http\Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $newStatus = $request->order_status;
        $currentStatus = $order->status_id;
        // Logic đặc biệt khi hủy đơn (status 6)
        if ($newStatus == 6) {
            // Hoàn mã giảm giá nếu hủy đơn (theo yêu cầu của bạn)
            // Có thể implement logic release promotion usage ở đây
        }
        $allowedTransitions = [
            1 => [2, 6],     // Chờ xác nhận → Chờ lấy hàng hoặc Hủy
            2 => [3],     // Chờ lấy hàng → Đang lấy hàng hoặc Hủy
            3 => [4],        // Đang lấy hàng → Đang vận chuyển
            4 => [5],        // Đang vận chuyển → Giao thành công
            // 5 và 6: Không cho thay đổi nữa
        ];

        if (!isset($allowedTransitions[$currentStatus]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatus])) {

            return redirect()->back()
                ->with('error', 'Không được phép chuyển sang trạng thái này!');
        }
        $order->update([
            'status_id' => $newStatus
        ]);

        return redirect()->back()
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreOrderItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
