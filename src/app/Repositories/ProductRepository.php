<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * Update an existing product by name or create a new one if it doesn't exist.
     *
     * @param array $data
     * @return Product
     */
    public function updateOrCreate(array $data)
    {
        return Product::updateOrCreate(
            ['name' => $data['name']],
            ['price' => $data['price']]
        );
    }
}
