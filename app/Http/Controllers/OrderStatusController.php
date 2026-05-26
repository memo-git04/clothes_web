<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Http\Requests\StoreOrderStatusRequest;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderStatuses = OrderStatus::all();
        return view('admin.modules.orderstatus.index_order_status', [
            'orderStatuses' => $orderStatuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.orderstatus.add_order_status');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderStatusRequest $request)
    {
        OrderStatus::create([
            'status_name' => $request->status_name,
        ]);
        //return
        return redirect()->route('order-status.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderStatusRequest $request, OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {
        //
    }
}
