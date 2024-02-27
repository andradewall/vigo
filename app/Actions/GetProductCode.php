<?php

namespace App\Actions;

use App\Models\Product;

class GetProductCode
{
    public static function run(Product $product): string
    {
        return $product->type->code_prefix . '-' . $product->code;
    }
}
