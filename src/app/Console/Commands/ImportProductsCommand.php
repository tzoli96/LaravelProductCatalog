<?php
use Illuminate\Console\Command;
use App\Services\ProductService;

class ImportProductsCommand extends Command
{
    protected $signature = 'import:products {file}';
    protected $description = 'Importálja a termékeket CSV fájlból';
    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $filePath = $this->argument('file');
        $this->productService->importProductsFromCsv($filePath);
        $this->info('Termékek importálása sikeresen megtörtént.');
    }
}
