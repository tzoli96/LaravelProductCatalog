<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Retrieve the category by name or create a new one if it doesn't exist.
     *
     * @param string $name
     * @return Category
     */
    public function firstOrCreate(string $name)
    {
        return Category::firstOrCreate(['name' => $name]);
    }
}
