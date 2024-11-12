<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ProductService;
use App\Models\Product;
use App\Models\Category;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $productService;

    protected function setUp(): void
    {
        parent::setUp();

        // Instantiate repositories and the service
        $productRepository = new ProductRepository();
        $categoryRepository = new CategoryRepository();
        $this->productService = new ProductService($productRepository, $categoryRepository);
    }

    /** @test */
    public function it_imports_products_from_csv_and_creates_products_and_categories()
    {
        // Sample CSV content
        $csvContent = <<<CSV
        Megnevezés,Ár,"Kategória 1","Kategória 2","Kategória 3"
        "Sample Product 1",1000,"Category A"
        "Sample Product 2",2000,"Category A","Category B"
        CSV;

        // Save CSV to an actual location
        $filePath = storage_path('app/temp/test_products.csv');
        file_put_contents($filePath, $csvContent);

        // Import products from CSV
        $this->productService->importProductsFromCsv($filePath);

        // Verify products were created
        $this->assertDatabaseHas('products', ['name' => 'Sample Product 1', 'price' => 1000]);
        $this->assertDatabaseHas('products', ['name' => 'Sample Product 2', 'price' => 2000]);

        // Verify categories were created and associated correctly
        $categoryA = Category::where('name', 'Category A')->first();
        $categoryB = Category::where('name', 'Category B')->first();

        $this->assertNotNull($categoryA);
        $this->assertNotNull($categoryB);

        $product1 = Product::where('name', 'Sample Product 1')->first();
        $product2 = Product::where('name', 'Sample Product 2')->first();

        $this->assertTrue($product1->categories->contains($categoryA));
        $this->assertTrue($product2->categories->contains($categoryA));
        $this->assertTrue($product2->categories->contains($categoryB));

        // Clean up the test file
        unlink($filePath);
    }
}
