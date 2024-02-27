<?php

beforeEach(function () {
    $this->user = \App\Models\User::factory()->create();
    $this->actingAs($this->user);
});

describe('name', function () {
    it('should not be able to create a product type without a name', function () {
        $this->post(route('types.store'), [
            'name'        => '',
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type with a name larger than 125 characters', function () {
        $this->post(route('types.store'), [
            'name'        => Str::repeat('a', 126),
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type if name already exists', function () {
        $productType = \App\Models\ProductType::factory()->create();

        $this->post(route('types.store'), [
            'name'        => $productType->name,
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        $this->assertDatabaseCount('product_types', 1);
    });
});

describe('code_prefix', function () {
    it('should not be able to create a product type without a code_prefix', function () {
        $this->post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => '',
        ])->assertSessionHasErrors(['code_prefix']);

        $this->assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type with a code_prefix larger than 120 characters', function () {
        $this->post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => Str::repeat('a', 121),
        ])->assertSessionHasErrors(['code_prefix']);

        $this->assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type if code_prefix already exists', function () {
        $productType = \App\Models\ProductType::factory()->create();

        $this->post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => $productType->code_prefix,
        ])->assertSessionHasErrors(['code_prefix']);

        $this->assertDatabaseCount('product_types', 1);
    });
});

describe('description', function () {
    it('should not be able to create a product type with a description larger than 255 characters', function () {
        $this->post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => Str::repeat('a', 256),
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['description']);

        $this->assertDatabaseCount('product_types', 0);
    });
});

describe('price', function () {
    it('should not be able to create a product type without its price', function () {
        $this->post(route('types.store'), [
            'price' => '',
        ])->assertSessionHasErrors(['price']);

        $this->assertDatabaseCount('product_types', 0);
    });

    it('can not create a product type with a invalid price format', function () {
        $this->post(route('types.store'), [
            'price' => 'invalid',
        ])->assertSessionHasErrors(['price']);

        $this->assertDatabaseCount('product_types', 0);
    });
});
