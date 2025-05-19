<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductCreated;
use App\Mail\ProductUpdated;


class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
public function store(ProductRequest $request)
{
    $validated = $request->validated();
    
    // Handle file upload if present
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $validated['image_path'] = $path;
    }
    
    $product = Product::create($validated);
    
    // Kirim email notifikasi
    try {
        Mail::to('admin@manajemenproduk.com')->send(new ProductCreated($product));
    } catch (\Exception $e) {
        // Log error jika pengiriman email gagal
        \Log::error('Gagal mengirim email: ' . $e->getMessage());
    }
    
    return redirect()->route('products.index')
                    ->with('success', 'Produk berhasil ditambahkan dan notifikasi email telah dikirim.');
}

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \App\Http\Requests\ProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
{
    $validated = $request->validated();
    
    // Handle file upload if present
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        
        $path = $request->file('image')->store('products', 'public');
        $validated['image_path'] = $path;
    }
    
    $product->update($validated);
    
    // Kirim email notifikasi
    try {
        Mail::to('admin@manajemenproduk.com')->send(new ProductUpdated($product));
    } catch (\Exception $e) {
        // Log error jika pengiriman email gagal
        \Log::error('Gagal mengirim email update: ' . $e->getMessage());
    }
    
    return redirect()->route('products.index')
                    ->with('success', 'Produk berhasil diperbarui dan notifikasi email telah dikirim.');
}

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
                        ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Get products for DataTables.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $products = Product::query();
        
        return DataTables::of($products)
            ->addColumn('action', function ($product) {
                return '<a href="'.route('products.edit', $product->id).'" class="btn btn-primary btn-sm">Edit</a> ' .
                       '<form action="'.route('products.destroy', $product->id).'" method="POST" style="display:inline">' .
                       csrf_field() . 
                       method_field('DELETE') .
                       '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah anda yakin?\')">Hapus</button></form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}