<?php

namespace App\Actions;

use App\Models\ProductType;

class CalculateAvailableSize
{
    public static function run(ProductType $type): float
    {
        $used = $type->load('products')
            ->products
            ->sum('size');

        return $type->max_size - $used;
    }
}
