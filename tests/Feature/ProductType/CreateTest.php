<?php

use App\Enums\BaseTypeEnum;
use Illuminate\Support\Str;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\{actingAs, assertDatabaseCount, post};

beforeEach(function () {
    $this->user = \App\Models\User::factory()->create();
    actingAs($this->user);
});

describe('name', function () {
    it('should not be able to create a product type without a name', function () {
        post(route('types.store'), [
            'name'        => '',
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type with a name larger than 125 characters', function () {
        post(route('types.store'), [
            'name'        => Str::repeat('a', 126),
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type if name already exists', function () {
        $productType = \App\Models\ProductType::factory()->create();

        post(route('types.store'), [
            'name'        => $productType->name,
            'description' => 'Product type description',
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['name']);

        assertDatabaseCount('product_types', 1);
    });
});

describe('code_prefix', function () {
    it('should not be able to create a product type without a code_prefix', function () {
        post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => '',
        ])->assertSessionHasErrors(['code_prefix']);

        assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type with a code_prefix larger than 120 characters', function () {
        post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => Str::repeat('a', 121),
        ])->assertSessionHasErrors(['code_prefix']);

        assertDatabaseCount('product_types', 0);
    });

    it('should not be able to create a product type if code_prefix already exists', function () {
        $productType = \App\Models\ProductType::factory()->create();

        post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => 'Product type description',
            'code_prefix' => $productType->code_prefix,
        ])->assertSessionHasErrors(['code_prefix']);

        assertDatabaseCount('product_types', 1);
    });
});

describe('description', function () {
    it('should not be able to create a product type with a description larger than 255 characters', function () {
        post(route('types.store'), [
            'name'        => 'Product type name',
            'description' => Str::repeat('a', 256),
            'code_prefix' => 'PT',
        ])->assertSessionHasErrors(['description']);

        assertDatabaseCount('product_types', 0);
    });
});

describe('price', function () {
    it('should not be able to create a product type without its price', function () {
        post(route('types.store'), [
            'price' => '',
        ])->assertSessionHasErrors(['price']);

        assertDatabaseCount('product_types', 0);
    });

    it('can not create a product type with a invalid price format', function () {
        post(route('types.store'), [
            'price' => 'invalid',
        ])->assertSessionHasErrors(['price']);

        assertDatabaseCount('product_types', 0);
    });
});

describe('base_type', function () {
    it('can not create a product type without a valid base type', function () {
        post(route('types.store'), [
            'base_type' => 'invalid',
        ])->assertSessionHasErrors(['base_type']);

        assertDatabaseCount('product_types', 0);
    });
});

describe('max_size', function () {
    it('saves max size as null if the base type is not measurable', function () {
        $name        = 'Product type name';
        $description = 'Product type description';
        $codePrefix  = 'PT';
        $price       = '10,01';

        post(route('types.store'), [
            'base_type'   => BaseTypeEnum::COUNTABLE->value,
            'max_size'    => '1,01',
            'name'        => $name,
            'description' => $description,
            'code_prefix' => $codePrefix,
            'price'       => $price,
        ])->assertSessionHasNoErrors();

        assertDatabaseCount('product_types', 1);
        assertDatabaseHas('product_types', [
            'base_type' => BaseTypeEnum::COUNTABLE,
            'max_size'  => null,
        ]);
    });
});

it('can create a product type', function () {
    $baseType    = BaseTypeEnum::MEASURABLE->value;
    $name        = 'Product type name';
    $description = 'Product type description';
    $codePrefix  = 'PT';
    $price       = '10,01';
    $maxSize     = '1,01';

    post(route('types.store'), [
        'base_type'   => $baseType,
        'name'        => $name,
        'description' => $description,
        'code_prefix' => $codePrefix,
        'price'       => $price,
        'max_size'    => $maxSize,
    ])->assertSessionHasNoErrors();

    assertDatabaseCount('product_types', 1);
    assertDatabaseHas('product_types', [
        'base_type'   => $baseType,
        'name'        => $name,
        'description' => $description,
        'code_prefix' => $codePrefix,
        'price'       => 10.01,
        'max_size'    => 1.01,
    ]);
});
