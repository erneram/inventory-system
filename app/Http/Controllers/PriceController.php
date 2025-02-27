<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use App\Models\Product;

class PriceController extends Controller
{
    public function index()
    {
        $prices = Price::with('product')->get();
        $products = Product::all();
        return view("prices.prices-table", compact("prices", "products"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'cost_price' => 'required|integer',
            'selling_price' => 'required|integer',
        ]);
        Price::create($data);
        return redirect()->route('prices.index')->with('success', 'Agregado');
    }
}
