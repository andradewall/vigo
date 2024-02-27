<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    private function cleanDocumentNumber(string $value): string
    {
        if (strlen($value) === 11) {
            return substr($value, 0, 3) . '.' . substr($value, 3, 3) . '.' . substr($value, 6, 3) . '-' . substr($value, 9, 2);
        } else {
            return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
        }
    }

    public function documentNumber(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $this->cleanDocumentNumber($value),
            set: fn (string $value) => preg_replace('/[^0-9]/', '', $value)
        );
    }

    public function rents(): HasMany
    {
        return $this->hasMany(Rent::class);
    }
}
