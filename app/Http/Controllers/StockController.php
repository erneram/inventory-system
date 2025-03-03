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
}
