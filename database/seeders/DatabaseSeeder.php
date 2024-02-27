<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\{Contact, Product, ProductType, Rent};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        echo "Creating 15 product types...\n";
        ProductType::factory(15)->create();

        echo "Creating 200 products...\n";
        Product::factory(200)->create();

        echo "Creating 20 contacts...\n";
        Contact::factory()->count(20)->create();

        //        echo "Creating 100 rents...\n";
        //
        //        for ($i = 0; $i < 100; $i++) {
        //            $contact = Contact::inRandomOrder()->first();
        //            $rent    = Rent::factory()
        //                ->for($contact, 'contact')
        //                ->create([
        //                    'contact_name'            => $contact->name,
        //                    'contact_main_phone'      => $contact->main_phone,
        //                    'contact_secondary_phone' => $contact->secondary_phone,
        //                    'contact_email'           => $contact->email,
        //                    'contact_address'         => $contact->address,
        //                ]);
        //
        //            $products = Product::query()
        //                ->where('is_rented', false)
        //                ->inRandomOrder()->limit(rand(1, 5))->get();
        //
        //            foreach ($products as $product) {
        //                $product->update(['is_rented' => true]);
        //                $rent->products()->attach($product, [
        //                    'price' => $product->price,
        //                ]);
        //            }
        //        }
    }
}
