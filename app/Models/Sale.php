<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function salesDetail()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
