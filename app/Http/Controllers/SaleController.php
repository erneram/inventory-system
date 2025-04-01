<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sale;
use App\Models\User;
use App\Models\SalesDetail;
use App\Models\InventoryMovement;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->get();
        $salesDetails = SalesDetail::with('sale', 'product')->get();
        $users = User::all();
        $products = Product::all();
        $prices = Price::all();
        $currentUserId = Auth::id();
        return view("sales.sales-table", compact('sales', 'users', 'products', 'prices', 'currentUserId', 'salesDetails'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:1',
            'products_array' => 'required|string',
        ]);
        try {
            DB::transaction(function () use ($data) {
                $sales = Sale::create([
                    'user_id' => $data['user_id'],
                    'total_price' => $data['total_price'],
                ]);
                $products = json_decode($data['products_array'], true);
                foreach ($products as $product) {
                    $product_price = Price::where('product_id', $product['product_id'])->first();
                    SalesDetail::create([
                        'sales_id' => $sales->id,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product_price->selling_price,
                    ]);
                    InventoryMovement::create([
                        'product_id' => $product['product_id'],
                        'user_id' => $data['user_id'],
                        'movement_type' => 'OUT',
                        'quantity' => $product['quantity'],
                    ]);
                    $stock = Stock::where('product_id', $product['product_id'])->first();
                    $stock->update([
                        'quantity' => $stock->quantity - $product['quantity'],
                    ]);
                }
            });
            return redirect()->route('sales.index')->with('success', 'Agregado');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('Error', 'No se pudo concretar la venta');
        }
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:1',
            'products_array' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($data, $id) {
                $sale = Sale::findOrFail($id);
                // ORIGINAL
                $originalDetails = SalesDetail::where('sales_id', $sale->id)->get();
                foreach ($originalDetails as $detail) {
                    $stock = Stock::where('product_id', $detail->product_id)->first();
                    $stock->update([
                        'quantity' => $stock->quantity + $detail->quantity,
                    ]);

                    InventoryMovement::create([
                        'product_id' => $detail->product_id,
                        'user_id' => $sale->user_id,
                        'movement_type' => 'IN', // devolver stock
                        'quantity' => $detail->quantity,
                    ]);
                }
                //ELIMINAR EL ANTERIOR PARA CREAR UNO NUEVO DESDE CERO
                SalesDetail::where('sales_id', $sale->id)->delete();
                $sale->update([
                    'user_id' => $data['user_id'],
                    'total_price' => $data['total_price'],
                ]);
                $products = json_decode($data['products_array'], true);
                foreach ($products as $product) {
                    $product_price = Price::where('product_id', $product['product_id'])->first();
                    SalesDetail::create([
                        'sales_id' => $sale->id,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['quantity'],
                        'unit_price' => $product_price->selling_price,
                    ]);
                    InventoryMovement::create([
                        'product_id' => $product['product_id'],
                        'user_id' => $data['user_id'],
                        'movement_type' => 'OUT',
                        'quantity' => $product['quantity'],
                    ]);
                    $stock = Stock::where('product_id', $product['product_id'])->first();
                    $stock->update([
                        'quantity' => $stock->quantity - $product['quantity'],
                    ]);
                }
            });
            return redirect()->route('sales.index')->with('success', 'Venta actualizada');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('Error', 'No se pudo actualizar la venta');
        }
    }


    public function delete($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Eliminado Correctamente');
    }
}
