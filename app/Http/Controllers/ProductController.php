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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ============ TRANG KHÁCH HÀNG: SHOP / TÌM KIẾM ============

    public function shop(Request $request)
    {
        return $this->renderShop($request, 'Tất cả sản phẩm');
    }

    public function shopMen(Request $request)
    {
        return $this->renderShop($request, 'Thời trang Nam', 'nam');
    }

    public function shopWomen(Request $request)
    {
        return $this->renderShop($request, 'Thời trang Nữ', 'nữ');
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        return $this->renderShop($request, 'Kết quả tìm kiếm', null, $q);
    }

    /**
     * Bộ máy chung cho shop / men / women / search.
     * Hỗ trợ lọc theo giới tính, danh mục, từ khóa và sắp xếp.
     */
    private function renderShop(Request $request, string $title, ?string $gender = null, ?string $q = null)
    {
        $q = $q !== null ? $q : trim((string)$request->input('q', ''));
        $sort = $request->input('sort', 'featured');
        $categoryId = $request->input('category');
        $brandId = $request->input('brand');

        $query = Product::with(['category', 'brand', 'variants.images']);

        // Lọc theo giới tính (dựa trên tên SP hoặc tên danh mục)
        if ($gender) {
            $query->where(function ($sub) use ($gender) {
                $sub->where('product_name', 'like', "%{$gender}%")
                    ->orWhereHas('category', fn($c) => $c->where('category_name', 'like', "%{$gender}%"));
            });
        }

        // Tìm kiếm theo tên SP / danh mục / thương hiệu
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('product_name', 'like', "%{$q}%")
                    ->orWhereHas('category', fn($c) => $c->where('category_name', 'like', "%{$q}%"))
                    ->orWhereHas('brand', fn($b) => $b->where('brand_name', 'like', "%{$q}%"));
            });
        }

        // Lọc theo danh mục cụ thể (sidebar)
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Lọc theo thương hiệu cụ thể (sidebar)
        if ($brandId) {
            $query->where('brand_id', $brandId);
        }

        // Sắp xếp
        $minPrice = ProductVariant::selectRaw('MIN(selling_price)')
            ->whereColumn('product_variants.product_id', 'products.id');
        switch ($sort) {
            case 'newest':
                $query->latest();
                break;
            case 'price-asc':
                $query->orderBy($minPrice, 'asc');
                break;
            case 'price-desc':
                $query->orderBy($minPrice, 'desc');
                break;
            default: // featured
                $query->latest('id');
        }

        $products = $query->paginate(12)->withQueryString();

        // Lấy danh mục cha (is_root = 0) và nạp các con trực tiếp
        $categories = Category::with(['children' => function ($query) {
            $query->with(['children' => function ($childQuery) {
                $childQuery->where('level', 2) // Only grandchildren
                ->orderBy('category_name');
            }])
                ->where('level', 1)
                ->orderBy('category_name');
        }])
            ->where('is_root', 1)
            ->where('level', [0, 1]) // Chỉ lấy cha cấp 1
            ->orderBy('category_name')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->category_name,
                    'children' => $category->children->map(function ($child) {
                        return [
                            'id' => $child->id,
                            'name' => $child->category_name,
                            'children' => $child->children->map(function ($grandchild) {
                                return [
                                    'id' => $grandchild->id,
                                    'name' => $grandchild->category_name,
                                ];
                            })
                        ];
                    })
                ];
            });
        $brands = Brand::orderBy('brand_name')->get();

        return view('shop', [
            'products'         => $products,
            'categories'       => $categories,
            'brands'           => $brands,
            'title'            => $title,
            'q'                => $q,
            'sort'             => $sort,
            'gender'           => $gender,
            'activeCategoryId' => $categoryId,
            'activeBrandId'    => $brandId,
        ]);
    }

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
        $categories = Category::where('is_root', 1)
            ->with('children.children')
            ->get();
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
                    empty($variantData['base_price'])){
                    continue; // bỏ qua nếu chua tick vào checkbox
                }
                $basePrice     = $this->normalizePrice($variantData['base_price'] ?? 0);
                $sellingPrice  = $this->normalizePrice($variantData['selling_price'] ?? 0);

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $colorId,
                    'size_id' => $sizeId,
                    'stock_quantity' => $variantData['stock_quantity'] ?? 0,
                    'base_price' => $basePrice,
                    'selling_price' => $sellingPrice,
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
        return redirect()->route('admin.products.index')->with('success', 'Thêm mới sản phẩm thành công!');
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
            'product_name' => $request->product_name,
//            'category_id' => $request->category_id,
//            'brand_id' => $request->brand_id,
//            'material_id' => $request->material_id,
            'description' => $request->description,
            'status' => 'active'
        ]);
        //update variants
        if ($request->has('variants')){
            foreach ($request->variants as $variantId => $variantData){
                $variant = ProductVariant::find($variantId);

                if ($variant) {
                    $basePrice     = $this->normalizePrice(isset($variantData['base_price']) ? $variantData['base_price'] : 0);
                    $sellingPrice  = $this->normalizePrice(isset($variantData['selling_price']) ? $variantData['selling_price'] : 0);

                    $variant->update([
                        'stock_quantity' => isset($variantData['stock_quantity']) ? $variantData['stock_quantity'] : 0,
                        'base_price' => $basePrice,
                        'selling_price' => $sellingPrice,
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

        // ====================== TẠO VARIANT MỚI (new_variants) ======================
        if ($request->has('new_variants')) {
            $colors = Color::pluck('color_name', 'id');
            $sizes  = Size::pluck('size_name', 'id');

            $productCode = strtoupper($this->shortname($product->product_name)) . $product->id;

            foreach ($request->new_variants as $key => $variantData) {
                // Bỏ qua nếu thiếu thông tin quan trọng
                if (empty($variantData['color_id']) || empty($variantData['size_id'])) {
                    continue;
                }

                $basePrice     = $this->normalizePrice($variantData['base_price'] ?? 0);
                $sellingPrice  = $this->normalizePrice($variantData['selling_price'] ?? 0);

                $variant = ProductVariant::create([
                    'product_id'      => $product->id,
                    'color_id'        => $variantData['color_id'],
                    'size_id'         => $variantData['size_id'],
                    'stock_quantity'  => $variantData['stock_quantity'] ?? 0,
                    'base_price'      => $basePrice,
                    'selling_price'   => $sellingPrice,
                    'sku'             => 'TEMP-' . uniqid(), // tạm thời
                ]);

                // ==================== TẠO SKU TỰ ĐỘNG ====================
                $colorName = Str::slug($colors[$variantData['color_id']] ?? 'color');
                $sizeName  = Str::slug($sizes[$variantData['size_id']] ?? 'size');

                $sku = $productCode
                    . '-' . strtoupper($colorName)
                    . '-' . strtoupper($sizeName)
                    . '-' . $variant->id;

                $variant->update(['sku' => $sku]);

                // ==================== UPLOAD ẢNH CHO VARIANT MỚI ====================
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

        return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

    }
}
