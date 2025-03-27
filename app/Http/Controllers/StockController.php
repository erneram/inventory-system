<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Product;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('product')->get();
        $products = Product::all();
        return view('stocks.stocks-table', compact('stocks', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer'
        ]);
        Stock::create($data);
        return redirect()->route('stocks.index')->with('success', 'Agregado');
    }
    public function update(Request $request, $id)
    {
        try {

            $data = $request->validate([
                'quantity' => 'required|integer|min:0'
            ]);
            $stock = Stock::findOrFail($id);
            $stock->update($data);
            return redirect()->route('stocks.index')->with('success', 'Stock Actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->route('stocks.index')->with('error', 'No se ha podido actualizar');
        }
    }
    public function delete($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();
        return redirect()->route('stocks.index')->with('success', 'Eliminado correctamente');
    }
}
