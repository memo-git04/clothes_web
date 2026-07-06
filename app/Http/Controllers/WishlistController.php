<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Danh sách yêu thích của người dùng hiện tại.
     */
    public function index()
    {
        $wishlists = Wishlist::with([
            'variant.product.category',
            'variant.images',
            'variant.size',
            'variant.color',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('wishlist', [
            'wishlists' => $wishlists,
        ]);
    }

    /**
     * Thêm/bỏ 1 biến thể khỏi wishlist (toggle).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
        ]);

        $existing = Wishlist::where('user_id', auth()->id())
            ->where('product_variant_id', $request->variant_id)
            ->first();

        if ($existing) {
            return back()->with('success', 'Sản phẩm đã có trong danh sách yêu thích!');
        }

        Wishlist::create([
            'user_id'            => auth()->id(),
            'product_variant_id' => $request->variant_id,
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích!');
    }

    /**
     * Xóa 1 mục wishlist (chỉ chủ sở hữu).
     */
    public function destroy(Wishlist $wishlist)
    {
        abort_unless($wishlist->user_id === auth()->id(), 403);

        $wishlist->delete();

        return back()->with('success', 'Đã bỏ khỏi danh sách yêu thích.');
    }
}
