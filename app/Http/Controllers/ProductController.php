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
        //save product_variant
        foreach ($request->variants as $variantData) {
            $variant = ProductVariant::create([
                'product_id' => $product->id,
                'color_id' => $variantData['color_id'],
                'size_id' => $variantData['size_id'],
                'sku' => 'TEMP-' . uniqid(),
                'stock_quantity' => $variantData['stock_quantity'],
                'base_price' => $variantData['base_price'],
                'selling_price' => $variantData['selling_price'],
                'original_price' => $variantData['original_price'],
            ]);

            $colorName = Str::slug($colors[$variantData['color_id']]);
            $sizeName  = Str::slug($sizes[$variantData['size_id']]);
            //sku format: PRODUCTCODE-COLOR-SIZE-VARIANTID
            $sku = $productCode
                . '-' . Str::upper($colorName)
                . '-' . Str::upper($sizeName)
                . '-' . $variant->id;
            $variant->update(['sku' => $sku]);
            //image product variant
            if (isset($variantData['images'])) {
                foreach ($variantData['images'] as $index => $image) {
                    $folder = 'products/product_' . $product->id;
                    $name = time().'_'.$index.'.'.$image->extension();
                    $imagePath = $image->storeAs($folder, $name, 'public');
                    ProductImage::create([
                        'product_variant_id' => $variant->id,
                        'image_url' => $imagePath,
                        'sort_order' => $index, // Sử dụng index để xác định thứ tự hiển thị ảnh
                        'is_primary' => $index === 0, // Đánh dấu ảnh đầu tiên là ảnh chính
                    ]);
                }
            }
        }
//        dd($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // ✅ Xoá file trong storage
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        // ✅ Xoá record DB
        $image->delete();

        return back()->with('success', 'Xoá ảnh thành công!');
    }
    public function destroyVariant($id)
    {
        $variant = ProductVariant::with('images')->findOrFail($id);

        // ✅ Xoá toàn bộ ảnh liên quan
        foreach ($variant->images as $img) {
            if ($img->image_url && Storage::disk('public')->exists($img->image_url)) {
                Storage::disk('public')->delete($img->image_url);
            }
            $img->delete();
        }

        // ✅ Xoá variant
        $variant->delete();

        return back()->with('success', 'Xoá biến thể thành công!');
    }
    public function show(Product $product)
    {
//        $categories = Category::all();
//        $brands = Brand::all();
//        $materials = Material::all();
//        $colors = \App\Models\Color::all();
//        $sizes = \App\Models\Size::all();

        return view('admin.modules.product.product_item',[
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load('variants.images');
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
        $materials = \App\Models\Material::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();
        return view('admin.modules.product.edit_product',[
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'materials' => $materials,
            'colors' => $colors,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        //update product
        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'material_id' => $request->material_id,
        ]);
        //update product variant
        foreach ($request->variants as $variantData){
            $variant = ProductVariant::find($variantData['id']);

            $variant->update([
                'stock_quantity' => $variantData['stock_quantity'],
                'base_price' => $variantData['base_price'],
                'selling_price' => $variantData['selling_price'],
                'original_price' => $variantData['original_price'],
            ]);
            //DELETE SELECTED IMAGES
            if (!empty($variantData['delete_images'])) {
                foreach ($variantData['delete_images'] as $imgId) {
                    $img = ProductImage::find($imgId);

                    if ($img) {
                        Storage::disk('public')->delete($img->image_url);
                        $img->delete();
                    }
                }
            }

            //ADD NEW IMAGES
            if (!empty($variantData['images'])) {
                foreach ($variantData['images'] as $index => $image) {

                    $folder = 'products/product_' . $product->id;
                    $name = time() . '_' . uniqid() . '.' . $image->extension();

                    $imagePath = $image->storeAs($folder, $name, 'public');

                    ProductImage::create([
                        'product_variant_id' => $variant->id,
                        'image_url' => $imagePath,
                        'sort_order' => $index,
                        'is_primary' => false
                    ]);
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
        //
    }
}
