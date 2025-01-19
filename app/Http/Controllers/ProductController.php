<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Index method
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    // Create method
    public function create()
    {
        return view('products.create');
    }

    // Store method
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|unique:products,name|max:255',
            'description' => 'required',
            // 'stock' => 'required|digits_between:1,15',
        ]);
        // Save product
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        // $product->stock = $request->stock;
        $product->price = 0;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    // Edit method
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Update method
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'name' => 'required|unique:products,name,' . $id . '|max:255',
            'description' => 'required',
            // 'stock' => 'required|digits_between:1,15',
        ]);

        // Update product
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        // $product->stock = $request->stock;
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    // Delete method
    public function delete(Request $request)
    {
        $customer = Product::findOrFail($request->id);
        $customer->delete();

        $customers = Product::all();

        return view('customers.index', compact('customers'));
    }
}
