<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\User;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('user')->get();
        $users = User::all();
        return view("sales.sales-table", compact("sales", "users"));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:1',
        ]);
        Sale::create($data);
        return redirect()->route('sales.index')->with('success', 'Agregado');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:1',
        ]);
        $cateogry = Sale::findOrFail($id);
        $cateogry->update($data);
        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente');
    }

    public function delete($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Eliminado Correctamente');
    }
}
