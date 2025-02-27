<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        $users = User::all();
        return view("sales.sales-table", compact("sales", "users"));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer',
            'total_price' => 'required|integer',
        ]);
        Sale::create($data);
        return redirect()->route('sales.index')->with('success', 'Agregado');
    }
}
