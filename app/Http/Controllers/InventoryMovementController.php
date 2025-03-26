<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryMovement;
use App\Models\User;
use App\Models\Product;

class InventoryMovementController extends Controller
{
    public function index()
    {
        $inventoryMovement = InventoryMovement::with('product', 'user')->get();
        $products = Product::all();
        $users = User::all();
        return view("inventoryMovement.inventory-movement-table", compact('inventoryMovement', 'products', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
            'movement_type' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);
        try {
            InventoryMovement::create($data);
            return redirect()->route('inventory-movement.index')->with('success', 'Movimiento actualizado');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $movementId)
    {
        $data = $request->validate([
            'product_id' => 'required|integer',
            'user_id' => 'required|integer',
            'movement_type' => 'required|string|max:50',
            'quantity' => 'required|integer|min:0',
        ]);
        try {
            $movement = InventoryMovement::findOrFail($movementId);
            $movement->update($data);
            return redirect()->route('inventory-movement.index')->with('success', 'Movimiento actualizado');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($movementId)
    {
        try {
            $movement = InventoryMovement::findOrFail($movementId);
            $movement->delete();
            return redirect()->route('inventory-movement.index')->with('success', 'Eliminado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
