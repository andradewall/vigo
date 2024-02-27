<?php

beforeEach(function () {
    $this->user        = \App\Models\User::factory()->create();
    $this->productType = \App\Models\ProductType::factory()->create();
    $this->actingAs($this->user);
});

describe('name', function () {
    it('should not be able to update a product type with a name larger than 125 characters', function () {
        $this->put(route('types.update', $this->productType), [
            'name'        => Str::repeat('a', 126),
            'description' => 'New description',
            'code_prefix' => 'NPT',
        ])->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('product_types', 1);
        $this->assertDatabaseHas('product_types', [
            'name'        => $this->productType->name,
            'description' => $this->productType->description,
            'code_prefix' => $this->productType->code_prefix,
        ]);
    });

    it('should not be able to update a product type if name already exists', function () {
        $newProductType = \App\Models\ProductType::factory()->create();

        $this->put(route('types.update', $this->productType), [
            'name'        => $newProductType->name,
            'description' => 'New description',
            'code_prefix' => 'NPT',
        ])->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('product_types', 2);
        $this->assertDatabaseHas('product_types', [
            'name'        => $this->productType->name,
            'description' => $this->productType->description,
            'code_prefix' => $this->productType->code_prefix,
        ]);
    });
});

describe('code_prefix', function () {
    it('should not be able to update a product type with a code_prefix larger than 120 characters', function () {
        $this->put(route('types.update', $this->productType), [
            'name'        => 'New name',
            'description' => 'New description',
            'code_prefix' => Str::repeat('a', 121),
        ])->assertSessionHasErrors(['code_prefix']);

        $this->assertDatabaseCount('product_types', 1);
        $this->assertDatabaseHas('product_types', [
            'name'        => $this->productType->name,
            'description' => $this->productType->description,
            'code_prefix' => $this->productType->code_prefix,
        ]);
    });

    it('should not be able to update a product type if code_prefix already exists', function () {
        $newProductType = \App\Models\ProductType::factory()->create();

        $this->put(route('types.update', $this->productType), [
            'name'        => 'New name',
            'description' => 'New description',
            'code_prefix' => $newProductType->code_prefix,
        ])->assertSessionHasErrors(['code_prefix']);

        $this->assertDatabaseCount('product_types', 2);
        $this->assertDatabaseHas('product_types', [
            'name'        => $this->productType->name,
            'description' => $this->productType->description,
            'code_prefix' => $this->productType->code_prefix,
        ]);
    });
});

describe('description', function () {
    it('should not be able to update a product type with a description larger than 255 characters', function () {
        $this->put(route('types.update', $this->productType), [
            'name'        => 'New name',
            'description' => Str::repeat('a', 256),
            'code_prefix' => 'NTP',
        ])->assertSessionHasErrors(['description']);

        $this->assertDatabaseCount('product_types', 1);
        $this->assertDatabaseHas('product_types', [
            'name'        => $this->productType->name,
            'description' => $this->productType->description,
            'code_prefix' => $this->productType->code_prefix,
        ]);
    });
});
