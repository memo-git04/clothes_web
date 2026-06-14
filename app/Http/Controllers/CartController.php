<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $variantId = $request->variant_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            $variant = ProductVariant::with('product')->find($variantId);

            $cart[$variantId] = [
                'name' => $variant->product->product_name,
                'price' => $variant->selling_price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã thêm vào giỏ hàng');

    }
}
