<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryMovement;

class InventoryMovementController extends Controller
{
    public function index()
    {
        $inventoryMovement = InventoryMovement::with('product', 'user')->get();
        return view("inventoryMovement.inventory-movement-table", compact("inventoryMovement"));
    }
}
