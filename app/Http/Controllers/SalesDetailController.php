<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SalesDetail;
use App\Models\Product;
use App\Models\Sale;

class SalesDetailController extends Controller
{
    public function index()
    {
        $salesDetails = SalesDetail::with('product', 'sale')->get();
        $sales = Sale::all();
        $products = Product::all();
        return view('salesDetail.sales-detail-table', compact('salesDetails', 'sales', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sales_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit_price' => 'required|integer',
        ]);
        SalesDetail::create($data);
        return redirect()->route('sales-details.index')->with('success', 'Agregado');
    }
}
