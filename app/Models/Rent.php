<?php

namespace App\Models;

use App\Enums\RentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};
use Illuminate\Database\Eloquent\{Casts\Attribute, Model, SoftDeletes};

class Rent extends Model
{
    use HasFactory;

    protected $casts = [
        'status'        => RentStatus::class,
        'starting_date' => 'datetime',
        'ending_date'   => 'datetime',
        'value'         => 'float',
        'shipping_fee'  => 'float',
    ];

    private function cleanContactDocumentNumber(string $value): string
    {
        if (strlen($value) === 11) {
            return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
        } else {
            return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
        }
    }

    public function contactDocumentNumber(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->cleanContactDocumentNumber($value),
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value)
        );
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('price');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
