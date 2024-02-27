<?php

namespace App\Actions;

use App\Enums\RentStatus;
use App\Models\{Contact, Product, Rent};
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\{DB, Log};
use Throwable;

class CreateRent
{
    /**
     * @param float $value
     * @param float $shipping_fee
     * @param string|null $notes
     * @param string $payment_method
     * @param float $discount_percentage
     * @param string $usage_address
     * @param int $contact_id
     * @param string $contact_name
     * @param string $contact_main_phone
     * @param string|null $contact_secondary_phone
     * @param string|null $contact_email
     * @param string $contact_address
     * @param Carbon $starting_date
     * @param Carbon $ending_date
     * @param RentStatus|null $status
     * @param array<Product> $products
     * @return array<string>
     * @throws Throwable
     */
    public static function run(
        float $value,
        float $shipping_fee,
        ?string $notes,
        string $payment_method,
        float $discount_percentage,
        string $usage_address,
        ?int $contact_id,
        string $contact_name,
        string $contact_main_phone,
        ?string $contact_secondary_phone,
        ?string $contact_email,
        string $contact_address,
        string $contact_document_number,
        Carbon $starting_date,
        Carbon $ending_date,
        ?RentStatus $status,
        array $products,
    ): array {
        DB::beginTransaction();

        try {
            $rent = Rent::create([
                'value'                   => $value,
                'shipping_fee'            => $shipping_fee,
                'starting_date'           => $starting_date,
                'ending_date'             => $ending_date,
                'payment_method'          => $payment_method,
                'notes'                   => $notes,
                'discount_percentage'     => $discount_percentage,
                'usage_address'           => $usage_address,
                'status'                  => $status,
                'contact_name'            => $contact_name,
                'contact_main_phone'      => $contact_main_phone,
                'contact_secondary_phone' => $contact_secondary_phone,
                'contact_email'           => $contact_email,
                'contact_address'         => $contact_address,
                'contact_document_number' => $contact_document_number,
            ]);

            if ($contact_id) {
                $rent->contact()->associate($contact_id);
            }

            foreach ($products as $product) {
                $rent->products()->attach($product['id'], [
                    'price' => $product['price'],
                ]);
            }

            $rent->refresh();

            $rent->products()->each(
                fn (Product $product) => $product->update(['is_rented' => true])
            );

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
            'entity' => $rent,
        ];
    }
}
