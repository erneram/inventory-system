<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'quantity_per_package'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
