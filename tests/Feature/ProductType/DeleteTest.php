<?php

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertSoftDeleted, delete};

beforeEach(function () {
    $this->user        = \App\Models\User::factory()->create();
    $this->productType = \App\Models\ProductType::factory()->create();
    actingAs($this->user);
});

it('can delete a product type', function () {
    delete(route('types.destroy', $this->productType))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('types.index'));

    assertDatabaseCount('product_types', 1);
    assertSoftDeleted('product_types', [
        'id' => $this->productType->id,
    ]);
});

it(
    'be sure that the product type wasn\'t deleted from the database, it was just marked as deleted (soft delete)',
    function () {
        delete(route('types.destroy', $this->productType))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('types.index'));

        expect($this->productType->refresh()->deleted_at)
            ->not
            ->toBeNull();
    }
);
