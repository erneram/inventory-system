<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Price;
use App\Models\User;
use App\Models\InventoryMovement;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        $users = User::all();
        return view('products.products-table', compact('products', 'categories', 'users'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validar
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'categories_id' => 'required|integer',
            'stock_quantity' => 'required|integer|min:0',
            'cost_price' => 'required|numeric|min:0',
        ]);
        $iva = 0.12;
        try {
            DB::transaction(function () use ($data, $iva) {
                $user = Auth::user();
                $product = Product::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'categories_id' => $data['categories_id'],
                ]);
                Stock::create([
                    'product_id' => $product->id,
                    'quantity' => $data['stock_quantity'],
                ]);
                Price::create([
                    'product_id' => $product->id,
                    'cost_price' => $data['cost_price'],
                    'selling_price' => $data['cost_price'] + ($data['cost_price'] * $iva),
                ]);
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'movement_type' => 'IN',
                    'quantity' => $data['stock_quantity'],
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error', $e->getMessage()]);
        }
        // redirijir
        return redirect()->route('products.index')->with('success', 'Producto agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrfail($id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Producto eliminado']);
    }
}
