<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $products = Product::with(['variants.firstImg'])->get();
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
    //shortname
    function shortname($string)
    {
        $words = explode('-', Str::slug($string));
        return collect($words)->map(fn($w) => $w[0])->implode('');
    }
    function normalizePrice($value)
    {
        if (!$value) return 0;

        // xóa dấu chấm (phân cách nghìn)
        $value = str_replace('.', '', $value);

        // đổi dấu phẩy thành dấu chấm (nếu có)
        $value = str_replace(',', '.', $value);

        return (float)$value;
    }

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
        //rut gon product name de tao sku
        $colors = Color::pluck('color_name', 'id');
        $sizes  = Size::pluck('size_name', 'id');

        $productCode = strtoupper($this->shortname($product->product_name)) . $product->id;

        //loop matrix color size de tao variant
        foreach ($request->variants as $colorId => $sizeData){
            foreach ($sizeData as $sizeId => $variantData){
                if ( empty($variantData['stock_quantity']) &&
                    empty($variantData['base_price']) &&
                    empty($variantData['selling_price'])) {
                    continue; // bỏ qua nếu chua tick vào checkbox
                }
                $basePrice     = $this->normalizePrice($variantData['base_price'] ?? 0);
                $sellingPrice  = $this->normalizePrice($variantData['selling_price'] ?? 0);
                $originalPrice = $this->normalizePrice($variantData['original_price'] ?? 0);

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                    'base_price' => $basePrice,
                    'selling_price' => $sellingPrice,
                    'original_price' => $originalPrice,
                    'sku' =>  'TEMP-' . uniqid(),
                ]);
                //generate sku
                $colorName = Str::slug($colors[$colorId] ?? 'color');
                $sizeName  = Str::slug($sizes[$sizeId] ?? 'size');

                $sku = $productCode
                    . '-' . strtoupper($colorName)
                    . '-' . strtoupper($sizeName)
                    . '-' . $variant->id;
                $variant->update(['sku' => $sku]);
                //upload images cho variant
                // upload images theo color
                $colorImages = $request->color_images[$colorId] ?? [];

                if (!empty($colorImages)) {
                    foreach ($colorImages as $index => $image) {

                        if ($image && $image->isValid()) {

                            $path = $image->store('products/product_' . $product->id, 'public');

                            ProductImage::create([
                                'product_variant_id' => $variant->id,
                                'image_url' => $path,
                                'sort_order' => $index,
                                'is_primary' => $index === 0,
                            ]);
                        }
                    }
                }
            }
        }

//        dd($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $materials = Material::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();

        return view('admin.modules.product.product_item',[
            'product' => $product,
            'colors' => $colors,
            'sizes' => $sizes,
            'categories' => $categories,
            'brands' => $brands,
            'materials' => $materials,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update([
//            'product_name' => $request->product_name,
//            'category_id' => $request->category_id,
//            'brand_id' => $request->brand_id,
//            'material_id' => $request->material_id,
            'description' => $request->description,
        ]);
        //update variants
        if ($request->has('variants')){
            foreach ($request->variants as $variantId => $variantData){
                $variant = ProductVariant::find($variantId);

                if ($variant) {
                    $basePrice     = $this->normalizePrice(isset($variantData['base_price']) ? $variantData['base_price'] : 0);
                    $sellingPrice  = $this->normalizePrice(isset($variantData['selling_price']) ? $variantData['selling_price'] : 0);
                    $originalPrice = $this->normalizePrice(isset($variantData['original_price']) ? $variantData['original_price'] : 0);

                    $variant->update([
                        'stock_quantity' => isset($variantData['stock_quantity']) ? $variantData['stock_quantity'] : 0,
                        'base_price' => $basePrice,
                        'selling_price' => $sellingPrice,
                        'original_price' => $originalPrice,
                    ]);
                    //delete old images
                    if (!empty($variantData['delete_images'])) {
                        foreach ($variantData['delete_images'] as $imgId) {

                            if (!$imgId) continue;

                            $img = ProductImage::find($imgId);
                            if ($img) {
                                Storage::disk('public')->delete($img->image_url);
                                $img->delete();
                            }
                        }
                    }

                    //upload new image
                    if (!empty($variantData['images'])) {
                        foreach ($variantData['images'] as $index => $image) {

                            if ($image && $image->isValid()) {

                                $folder = 'products/product_' . $product->id;
                                $name = time() . '_' . $index . '.' . $image->extension();

                                $path = $image->storeAs($folder, $name, 'public');

                                ProductImage::create([
                                    'product_variant_id' => $variant->id,
                                    'image_url' => $path,
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

    }
}
