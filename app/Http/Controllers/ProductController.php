<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // =============================
        // Trial Version Limitation
        // =============================
        if(env('APP_TRIAL') == true){
            $limit = env('TRIAL_PRODUCT_LIMIT', 5);
            $currentCount = Product::count();

            if($currentCount >= $limit){
                return redirect()
                ->route('products.index')
                ->with('error', 'Versi trial dibatasi maksimal '.$limit.'produk.');
            }
        }

        Product::create($request->all());

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');
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
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->all());
        return redirect()
        ->route('products.index')
        ->with('success', 'Produk berhasil diperbarui');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()
        ->route('products.index')
        ->with('success', 'Produk berhasil dihapus');

    }
}
