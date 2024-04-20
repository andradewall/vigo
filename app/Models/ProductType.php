<?php

namespace App\Models;

use App\Enums\BaseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Model};

class ProductType extends Model
{
    use HasFactory;

    protected $casts = [
        'max_size'  => 'float',
        'price'     => 'float',
        'base_type' => BaseTypeEnum::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
