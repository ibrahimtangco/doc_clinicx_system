<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Category;
use App\Models\UnitType;
use Illuminate\Http\Request;
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
        $request = $request->validated();
        $product = $this->productModel->updateProduct($request, $product);

        if (!$product) {
            emotify('error', 'Failed to update product');
            return redirect()->route('products.index');
        }

        emotify('success', 'Product updated successfully');
        return redirect()->route('products.index');
    }

    public function downloadProductList(Request $request)
    {

        // Validate input
        $validated = $request->validate([
            'start' => 'nullable|date_format:m/d/Y',
            'end' => 'nullable|date_format:m/d/Y',
        ]);

        $fromDate = $validated['start'] ?? null;
        $toDate = $validated['end'] ?? null;

        // Query transactions
        $query = Product::query();

        // Apply date filters
        if ($validated['start']) {
            $start = Carbon::createFromFormat('m/d/Y', $validated['start'])->startOfDay();
            $query->where('created_at', '>=', $start);
        }

        if ($validated['end']) {
            $end = Carbon::createFromFormat('m/d/Y', $validated['end'])->endOfDay();
            $query->where('created_at', '<=', $end);
        }

        // Retrieve transactions
        $products = $query->get();

        // Handle missing transactions gracefully
        if ($products->isEmpty()) {

            emotify('error', 'No products found for the specified data range.');
            return redirect()->back();
        }


        try {
            $path = public_path('images/FILARCA.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

            $html = view(
                'reports_template.product_list',
                [
                    'imageSrc' => $src,
                    'products' => $products,
                    'fromDate' => $fromDate,
                    'toDate' => $toDate
                ]
            )->render();
            $currentDateTime = Carbon::now()->format('d-m-Y');

            $pdfPath = public_path('Filarca - Rabena_Products_List_' . $currentDateTime . '.pdf');

            Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);

            return response()->download($pdfPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            emotify('error', 'An error occurred while generating the PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
