<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('items')
        ->latest()
        ->get();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.qty' => 'required|integer|min:1',
            'pay' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();

        try {

            $total = 0;

            // VALIDASI STOK + HITUNG TOTAL
            foreach ($request->products as $item) {

                $product = Product::findOrFail($item['id']);

                if ($item['qty'] > $product->stock) {
                    return back()->with('error', 'Stok ' . $product->name . ' tidak mencukupi!');
                }

                $total += $product->price * $item['qty'];
            }

            if ($request->pay < $total) {
                return back()->with('error', 'Uang pembayaran kurang!');
            }

            $transaction = Transaction::create([
                'transaction_code' => 'TRX-' . time(),
                'total' => $total
            ]);

            foreach ($request->products as $item) {

                $product = Product::findOrFail($item['id']);
                $subtotal = $product->price * $item['qty'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ]);

                $product->decrement('stock', $item['qty']);
            }

            DB::commit();

            return redirect()->route('transactions.receipt', $transaction->id);

            // return redirect()->route('transactions.create')
            //     ->with('success', 'Transaksi berhasil!');

        } catch (\Exception $e) {

            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function show($id)
    {
        $transaction = Transaction::with('items.product')
        ->findOrFail($id);
        
        return view('transactions.show', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        $transaction->load('items.product');
        return view('transaction.receipt', compact('transaction'));
    }

}
