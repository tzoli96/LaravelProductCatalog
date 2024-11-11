<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function firstOrCreate(string $name)
    {
        return Category::firstOrCreate(['name' => $name]);
    }
}
