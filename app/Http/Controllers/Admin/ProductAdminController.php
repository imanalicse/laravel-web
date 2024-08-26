<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        $total_product = Product::count();
        $search_key  = $request->query('search_key');

        return view('admin.product.index', compact('products', 'total_product', 'search_key'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price ?? 0;
        if ($request->hasFile('image')) {
            $path = $request->image->store('public/uploads');
            $product->image = $path ?: '';
        }
        // Mass assignment
        // $data = $request->all();
        // Product::create($data);
        $product->save();
        return redirect()->route('admin.products.index')->with('success', 'Product has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view("admin.product.edit", ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Product $product): \Illuminate\Http\RedirectResponse
    {
        try {
            $product->update($request->all());
            return redirect()->route('admin.products.index')->with('success', 'Product has been edited');
        }
        catch (\Exception $exception) {
            $message = $exception->getMessage();
            return redirect()->route('admin.products.index')->with('error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): \Illuminate\Http\RedirectResponse
    {
        $product->delete();
        return redirect()->back()->with('success', 'Product has been deleted');
    }
}
