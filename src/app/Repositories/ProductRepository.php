<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function updateOrCreate(array $data)
    {
        return Product::updateOrCreate(
            ['name' => $data['name']],
            ['price' => $data['price']]
        );
    }
}
