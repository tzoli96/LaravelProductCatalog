<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\XmlFeedService;
use App\Models\Product;
use App\Models\Category;

class XmlFeedServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $xmlFeedService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->xmlFeedService = new XmlFeedService();
    }

    /** @test */
    public function it_generates_correct_xml_feed()
    {
        // Create sample data
        $product1 = Product::create(['name' => 'Sample Product 1', 'price' => 1000]);
        $product2 = Product::create(['name' => 'Sample Product 2', 'price' => 2000]);

        $categoryA = Category::create(['name' => 'Category A']);
        $categoryB = Category::create(['name' => 'Category B']);

        $product1->categories()->attach($categoryA->id);
        $product2->categories()->attach([$categoryA->id, $categoryB->id]);

        // Generate the XML feed
        $xmlContent = $this->xmlFeedService->generateXmlFeed();

        // Load XML content into a SimpleXMLElement for assertions
        $xml = new \SimpleXMLElement($xmlContent);

        // Assertions on the XML structure and content
        $this->assertEquals('Sample Product 1', (string) $xml->product[0]->title);
        $this->assertEquals('1000', (string) $xml->product[0]->price);
        $this->assertEquals('Category A', (string) $xml->product[0]->categories->category[0]);

        $this->assertEquals('Sample Product 2', (string) $xml->product[1]->title);
        $this->assertEquals('2000', (string) $xml->product[1]->price);
        $this->assertEquals('Category A', (string) $xml->product[1]->categories->category[0]);
        $this->assertEquals('Category B', (string) $xml->product[1]->categories->category[1]);
    }
}
