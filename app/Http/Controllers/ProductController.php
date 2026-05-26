<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImage;
use App\Models\ProductVariant;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = \App\Models\Brand::all();
        $categories = \App\Models\Category::all();
        $materials = \App\Models\Material::all();
        $products = Product::all();
        return view('admin.modules.product.index_product', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
            'materials' => $materials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        $materials = \App\Models\Material::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();
        return view('admin.modules.product.add_product',[
            'categories' => $categories,
            'brands' => $brands,
            'materials' => $materials,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //create product
        $product = Product::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
        ]);
        //save product_variant
        foreach ($request->variants as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $variantData['color_id'],
                'size_id' => $variantData['size_id'],
                'sku' => $variantData['sku'],
                'stock_quantity' => $variantData['stock_quantity'],
                'base_price' => $variantData['base_price'],
                'selling_price' => $variantData['selling_price'],
                'original_price' => $variantData['original_price'],
            ]);
            //image product variant
            if (isset($variantData['images'])) {
                foreach ($variantData['images'] as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_variant_id' => $variant->id,
                        'image_url' => $imagePath,
                        'sort_order' => $index, // Sử dụng index để xác định thứ tự hiển thị ảnh
                        'is_primary' => $index === 0, // Đánh dấu ảnh đầu tiên là ảnh chính
                    ]);
                }
            }
        }
        dd($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
