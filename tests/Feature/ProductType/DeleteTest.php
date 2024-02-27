<?php

beforeEach(function () {
    $this->user        = \App\Models\User::factory()->create();
    $this->productType = \App\Models\ProductType::factory()->create();
    $this->actingAs($this->user);
});

it('should be able to delete a product type', function () {
    $this->delete(route('types.destroy', $this->productType))
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('types.index'));

    $this->assertDatabaseCount('product_types', 1);
    $this->assertSoftDeleted('product_types', [
        'id' => $this->productType->id,
    ]);
});

it(
    'be sure that the product type wasn\'t deleted from the database, it was just marked as deleted (soft delete)',
    function () {
        $this->delete(route('types.destroy', $this->productType))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('types.index'));

        $this->expect($this->productType->refresh()->deleted_at)
            ->not
            ->toBeNull();
    }
);
