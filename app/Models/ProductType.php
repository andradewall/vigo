<?php

namespace App\Models;

use App\Enums\BaseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\{Model};

/**
 * App\Models\ProductType
 *
 * @property int $id
 * @property string $code_prefix
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Database\Factories\ProductTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereCodePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductType withoutTrashed()
 * @mixin \Eloquent
 */
class ProductType extends Model
{
    use HasFactory;

    protected $casts = [
        'price'     => 'float',
        'base_type' => BaseTypeEnum::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
