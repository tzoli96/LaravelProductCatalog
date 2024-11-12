<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ProductService;

class ImportProductsCommand extends Command
{
    protected $signature = 'import:products {file}';
    protected $description = 'Imports products from a CSV file';
    protected ProductService $productService;

    /**
     * Constructor to initialize the ProductService.
     *
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    /**
     * Execute the console command to import products.
     *
     * @return void
     */
    public function handle(): void
    {
        $filePath = $this->argument('file');
        $this->productService->importProductsFromCsv($filePath);
        $this->info('Product import completed successfully.');
    }
}
