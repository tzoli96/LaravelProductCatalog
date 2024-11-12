<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductService
{
    /**
     * @var ProductRepository
     */
    protected ProductRepository $productRepository;

    /**
     * @var CategoryRepository
     */
    protected CategoryRepository $categoryRepository;

    /**
     * Constructor to initialize the repositories.
     *
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Imports products from a CSV file and syncs categories.
     *
     * @param string $filePath
     * @return void
     */
    public function importProductsFromCsv(string $filePath): void
    {
        $csvData = array_map('str_getcsv', file($filePath));
        array_shift($csvData); // Remove header row

        foreach ($csvData as $row) {
            $row = array_pad($row, 5, null);
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
