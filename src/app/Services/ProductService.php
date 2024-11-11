<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductService
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function importProductsFromCsv(string $filePath): void
    {
        $csvData = array_map('str_getcsv', file($filePath));
        array_shift($csvData); // Remove header row

        foreach ($csvData as $row) {
            [$productName, $price, $category1, $category2, $category3] = $row;

            // Product creation or update
            $product = $this->productRepository->updateOrCreate([
                'name' => $productName,
                'price' => (int) $price
            ]);

            // Categories assignment
            $categories = array_filter([$category1, $category2, $category3]);
            $categoryIds = array_map(
                fn($categoryName) => $this->categoryRepository->firstOrCreate($categoryName)->id,
                $categories
            );

            $product->categories()->sync($categoryIds);
        }
    }
}
