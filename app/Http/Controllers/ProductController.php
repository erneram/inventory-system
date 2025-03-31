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
        $prices = Price::all();
        $stocks = Stock::all();
        $categories = Category::all();
        $users = User::all();
        return view('products.products-table', compact('products', 'categories', 'users', 'prices', 'stocks'));
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
            'categories_id' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:1',
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

    public function update(Request $request, $productId)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'categories_id' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:1',
        ]);
        $iva = 0.12;
        try {
            DB::transaction(function () use ($data, $iva, $productId) {
                $user = Auth::user();
                $product = Product::findOrFail($productId);
                $product->update([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'categories_id' => $data['categories_id'],
                ]);
                $stock = Stock::where('product_id', $product->id)->first();
                $oldStock = $stock ? $stock->quantity : 0;
                if ($oldStock) {
                    $stock->update([
                        'quantity' => $data['stock_quantity']
                    ]);
                } else {
                    $stock->create([
                        'product_id' => $product->id,
                        'quantity' => $data['stock_quantity']
                    ]);
                }
                $price = Price::where('product_id', $product->id)->first();
                if ($price) {
                    $price->update([
                        'cost_price' => $data['cost_price'],
                        'selling_price' => $data['cost_price'] + ($data['cost_price'] * $iva),
                    ]);
                } else {
                    Price::create([
                        'product_id' => $product->id,
                        'cost_price' => $data['cost_price'],
                        'selling_price' => $data['cost_price'] + ($data['cost_price'] * $iva),
                    ]);
                }
                $differenceQuantity = $data['stock_quantity'] - $oldStock->quantity;
                if ($differenceQuantity !== 0) {
                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'movement_type' => $differenceQuantity > 0 ? 'IN' : 'OUT',
                        'quantity' => abs($differenceQuantity),
                    ]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error', $e->getMessage()]);
        }
        ;
        return redirect()->route('products.index')->with('success', 'Producto actualizado');
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
     * Remove the specified resource from storage.
     */
    public function delete($productId)
    {
        $product = Product::findOrFail($productId);
        dd($product);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Eliminado correctamente');
    }
}
