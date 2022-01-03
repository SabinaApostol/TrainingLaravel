<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldProducts extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'price', 'image'];

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Orders::class, 'product_order', 'order_id','product_id');
    }
}