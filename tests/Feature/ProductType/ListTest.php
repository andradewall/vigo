<?php

it('should be able to list all product types', function () {
    $user = \App\Models\User::factory()->create();
    \App\Models\ProductType::factory()->count(10)->create();
    $productTypes = \App\Models\ProductType::all();

    $this->actingAs($user);
    $response = $this->get(route('types.index'));
    $response->assertViewIs('product_types.index');

});
