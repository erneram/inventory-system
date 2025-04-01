<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SalesDetail;
use App\Models\InventoryMovement;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Price;
use App\Models\Sale;
use App\Models\User;

class SalesDetailController extends Controller
{
    public function index()
    {
        $salesDetails = SalesDetail::with('product', 'sale')->get();
        $products = Product::all();
        $users = User::all();
        return view('salesDetail.sales-detail-table', compact('salesDetails', 'products', 'users'));
    }

    // 
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'product_id' => 'required|integer|min:1',
                'quantity' => 'required|integer|min:1',
                'user_id' => 'required|integer|min:1'
            ]);
            DB::transaction(function () use ($data) {
                $product_price = Price::where('product_id', $data['product_id'])->first();
                $sales = Sale::create([
                    'user_id' => $data['user_id'],
                    'total_price' => $product_price * $data['quantity'],
                ]);
                SalesDetail::create([
                    'sales_id' => $sales->id,
                    'product_id' => $data['product_id'],
                    'quantity' => $data['quantity'],
                    'unit_price' => $product_price->selling_price,
                ]);
                InventoryMovement::create([
                    'product_id' => $data['product_id'],
                    'user_id' => $data['user_id'],
                    'movement_type' => 'OUT',
                    'quantity' => $data['quantity'],
                ]);
                $stock = Stock::where('product_id', $data['product_id'])->first();
                $stock->update([
                    'quantity' => $stock->quantity - $data['quantity'],
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->route('sales-details.index')->with('success', 'Agregado');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'sales_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:1',
        ]);
        $salesDetail = SalesDetail::findOrFail($id);
        $salesDetail->update($data);
        return redirect()->route('sales-details.index')->with('success', 'Detalle de venta actualizado correctamente');
    }
    public function delete($id)
    {
        SalesDetail::findOrFail($id)->delete();
        return redirect()->route('sales-details.index')->with('success', 'Eliminado Correctamente');
    }
}


