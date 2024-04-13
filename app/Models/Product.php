<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'size'  => 'float',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    public function rents(): BelongsToMany
    {
        return $this->belongsToMany(Rent::class)->withPivot('price');
    }
}
