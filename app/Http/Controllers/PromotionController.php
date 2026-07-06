<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotion::all();
        return view('admin.modules.promotion.index_promotion', [
            'promotions' => $promotions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.promotion.add_promotion');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePromotionRequest $request)
    {
        Promotion::create([
            'code' => $request->code,
            'promotion_name' => $request->promotion_name,
            'description' => $request->description,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'per_user_limit' => 1,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        return redirect()->route('admin.promotions.index')->with('success', 'Thêm mã giảm giá thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        return view('admin.modules.promotion.edit_promotion', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $promotion->update([
            'code' => $request->code,
            'promotion_name' => $request->promotion_name,
            'description' => $request->description,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount,
            'usage_limit' => $request->usage_limit,
            'status' => $request->is_active,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
//        dd($data);
        return redirect()->back()->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        //check if có đơn hàng đang áp mã
        if ($promotion->orders()->exists()) {
            return redirect()->back()->with('error', 'Mã khuyến mãi đang được sử dụng, không thể xóa');
        }
        $promotion->delete();
        return redirect()->back()->with('success', 'Xóa mã khuyến mãi thành công!');
    }
}
