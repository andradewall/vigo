<?php

namespace App\Actions;

use App\Enums\RentStatus;
use App\Models\{Product, Rent};
use Exception;
use Illuminate\Support\Facades\{DB, Log};
use Throwable;

class CloseRent
{
    /**
     * @throws Throwable
     */
    public static function run(Rent $rent): array
    {
        DB::beginTransaction();

        try {
            $rent->update([
                'status' => RentStatus::CLOSED,
            ]);

            $rent->products()->each(fn (Product $product) => $product->update(['is_rented' => false]));

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            Log::error('CreateRent', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return [
                'status' => 'error',
            ];
        }

        return [
            'status' => 'success',
        ];
    }
}
