<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Rules\ProductQuantity;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('details.product')->orderBy('created_at', 'desc')->get();

        return view('admin.transactions.index', compact('transactions'))->with('title', 'Transactions | View List');
    }


    public function create()
    {
        $products = Product::where('status', true)->get();
        return view('admin.transactions.create', compact('products'))->with('title', 'Transactions | Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => [
                    'required',
                    'numeric',
                    'min:1',
                    new ProductQuantity
                ],
            ],
            [
                'products.*.product_id.exists' => 'The selected product does not exist',
                'products.*.quantity.required' => 'The quantity field is required',
                'products.*.quantity.numeric' => 'The quantity field must be a number',
                'products.*.quantity.min' => 'The quantity must not be less than 1',
            ]
        );

        $totalAmount = 0;
        $groupedProducts = [];

        // Group products by product_id and sum the quantities
        foreach ($validated['products'] as $productData) {
            $productId = $productData['product_id'];
            if (isset($groupedProducts[$productId])) {
                // If product already exists, just add the quantity
                $groupedProducts[$productId]['quantity'] += $productData['quantity'];
            } else {
                // Otherwise, initialize the entry with product data
                $groupedProducts[$productId] = $productData;
            }
        }

        // Calculate total amount and handle the transaction
        foreach ($groupedProducts as $productData) {
            $product = Product::find($productData['product_id']);

            if (!$product) {
                return redirect()->back()->withErrors(['Something went wrong. Try again']);
            }

            $productAmount = $product->selling_price * $productData['quantity'];
            $totalAmount += $productAmount;
        }

        // Get current date
        $currentDate = Carbon::now()->format('Ymd');

        // Generate transaction code
        $lastTransaction = Transaction::orderBy('id', 'desc')->first();
        $lastId = $lastTransaction ? $lastTransaction->id : 0;
        $transactionCode = 'TRX-' . $currentDate . '-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        $transaction = Transaction::create([
            'transaction_code' => $transactionCode,
            'total_amount' => $totalAmount
        ]);

        // Process transaction details and update product quantities
        foreach ($groupedProducts as $productData) {
            $product = Product::find($productData['product_id']);

            if (!$product) {
                return redirect()->back()->withErrors(['Something went wrong. Try again']);
            }

            DB::transaction(function () use ($transaction, $productData, $product) {
                // Create the transaction detail
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'price_at_time_of_sale' => $product->selling_price,
                    'total_amount' => $productData['quantity'] * $product->selling_price
                ]);

                // Deduct the quantity from the product
                $product->update([
                    'quantity' => $product->quantity - $productData['quantity']
                ]);
            });
        }

        // Set success message before clearing session
        emotify('success', 'Successfully created transaction');

        return redirect()->route('transactions.index');
    }

    public function downloadTransactionRecords(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'start' => 'nullable|date_format:m/d/Y',
            'end' => 'nullable|date_format:m/d/Y',
        ]);

        // Query transactions
        $query = Transaction::query();

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
        $transactions = $query->get();

        // Handle missing transactions gracefully
        if ($transactions->isEmpty()) {

            emotify('error', 'No transactions found for the specified data range.');
            return redirect()->back();
        }

        try {
            // Load logo for the PDF
            $path = public_path('images/FILARCA.png');
            if (!file_exists($path)) {
                throw new \Exception('Logo file not found.');
            }

            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $src = 'data:image/' . $type . ';base64,' . base64_encode($data);

            // Generate HTML
            $html = view('reports_template.transactions_list', [
                'imageSrc' => $src,
                'transactions' => $transactions,
            ])->render();

            // Generate PDF
            $currentDateTime = Carbon::now()->format('d-m-Y');
            $pdfPath = public_path('Filarca_Rabena_Transaction_Records_' . $currentDateTime . '.pdf');

            Browsershot::html($html)
                ->margins(15.4, 15.4, 15.4, 15.4)
                ->showBackground()
                ->save($pdfPath);

            // Download PDF response
            return response()->download($pdfPath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            // Handle errors

            emotify('error', 'An error occurred while generating the PDF: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
