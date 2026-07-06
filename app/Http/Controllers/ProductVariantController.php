<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
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
    public function store(StoreProductVariantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductVariantRequest $request, ProductVariant $productVariant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $productVariant)
    {
        try {
            // check đơn hàng
            if ($productVariant->orderItems()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể xoá vì đã có đơn hàng'
                ], 422);
            }

            // check còn hàng
            if ($productVariant->stock_quantity > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phải hết hàng mới được xoá'
                ], 422);
            }

            //get product truoc khi xoa
            $product = $productVariant->product;

            // xoá ảnh
            foreach ($productVariant->images as $img) {
                Storage::disk('public')->delete($img->image_url);
                $img->delete();
            }

            // soft delete
            $productVariant->delete();

            //check sau khi delete
            if ($product->variants()->count() == 0) {
                $product->update([
                    'status' => 'inactive'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Đã xoá biến thể'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

}
