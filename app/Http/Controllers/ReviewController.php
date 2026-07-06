<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Khách hàng gửi đánh giá cho 1 sản phẩm đã mua (đơn Giao thành công).
     * Review mặc định chờ admin duyệt (is_approved = false).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:2000',
        ], [
            'rating.required' => 'Vui lòng chọn số sao.',
        ]);

        $orderItem = OrderItem::with('order', 'variant')->findOrFail($data['order_item_id']);

        // Bảo đảm order_item thuộc về user hiện tại
        abort_unless($orderItem->order && $orderItem->order->user_id === auth()->id(), 403);

        // Chỉ cho đánh giá khi đơn đã Giao thành công
        if ($orderItem->order->status_id !== Order::STATUS_COMPLETED) {
            return back()->with('error', 'Chỉ có thể đánh giá sản phẩm của đơn đã Giao thành công.');
        }

        // Không cho đánh giá trùng cho cùng 1 order_item
        $already = Review::where('order_item_id', $orderItem->id)
            ->where('user_id', auth()->id())
            ->exists();
        if ($already) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        $productId = $orderItem->variant?->product_id;

        Review::create([
            'user_id'       => auth()->id(),
            'product_id'    => $productId,
            'order_item_id' => $orderItem->id,
            'rating'        => $data['rating'],
            'comment'       => $data['comment'] ?? null,
            'is_approved'   => false,
        ]);

        return back()->with('success', 'Cảm ơn bạn! Đánh giá sẽ hiển thị sau khi được duyệt.');
    }

    // ============ ADMIN: DUYỆT ĐÁNH GIÁ ============

    public function adminIndex(Request $request)
    {
        $filter = $request->input('status'); // pending | approved | null
        $query = Review::with(['user', 'product'])->latest();

        if ($filter === 'pending') {
            $query->where('is_approved', false);
        } elseif ($filter === 'approved') {
            $query->where('is_approved', true);
        }

        return view('admin.modules.review.index', [
            'reviews' => $query->paginate(15),
            'filter'  => $filter,
        ]);
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);
        return back()->with('success', 'Đã duyệt đánh giá.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Đã xóa đánh giá.');
    }
}
