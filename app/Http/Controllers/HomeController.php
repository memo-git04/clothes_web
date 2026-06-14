<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::with([
            'category',
            'brand',
            'material',
            'variants.images'
        ])->get();
//        dd($products);
        return view('home',[
            'products' => $products,
        ]);
    }

    public function productDetail($id){
        $product = Product::with([
            'category',
            'brand',
            'material',
            'variants.color',
            'variants.size',
            'variants.images'
        ])->findOrFail($id);
        $relatedProducts = Product::where('id', '!=', $id)->take(5)->get();
        return view('product_details',[
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
