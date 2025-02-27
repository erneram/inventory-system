<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'categories_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function prices()
    {
        return $this->hasMany(Price::class);
    }
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}

