<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\UnitType;
use Spatie\Browsershot\Browsershot;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }


    public function index()
    {
        $products = Product::all();

        return view('admin.products.index', compact('products'))->with('title', 'Products | View List');
    }

    public function create()
    {
        $categories = Category::where('availability', '1')->get();
        $unitTypes = UnitType::where('availability', '1')->get();

        return view('admin.products.create', compact('categories', 'unitTypes'))->with('title', 'Products | Create');
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $product = $this->productModel->storeProduct($validated);

        if (!$product) {
            emotify('error', 'Failed to add product');
            return redirect()->route('products.index');
        }

        emotify('success', 'Product added successfully');
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('availability', '1')->get();
        $unitTypes = UnitType::where('availability', '1')->get();

        return view('admin.products.edit', compact(['categories', 'unitTypes', 'product']))->with('title', 'Products | Update Details');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product = $this->productModel->updateProduct($validated, $product);

        if (!$product) {
            emotify('error', 'Failed to update product');
            return redirect()->route('products.index');
        }

        emotify('success', 'Product updated successfully');
        return redirect()->route('products.index');
    }

    public function downloadProductList()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            emotify('error', 'No products found.'); // Short and user-friendly message
            return redirect()->back(); // Preserves input data for better user experience
        }
        
        $path = public_path('images/FILARCA.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

        $html = view('reports_template.product_list', ['imageSrc' => $src, 'products' => $products])->render();
        $currentDateTime = Carbon::now()->format('d-m-Y');

        $pdfPath = public_path('Filarca - Rabena_Products_List_' . $currentDateTime . '.pdf');

        Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);
                
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }
}
