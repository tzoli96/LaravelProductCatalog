<?php
namespace App\Services;

use App\Models\Product;
use SimpleXMLElement;

class XmlFeedService
{
    /**
     * Generates an XML feed from products and their categories.
     *
     * @return string
     */
    public function generateXmlFeed(): string
    {
        $products = Product::with('categories')->get();
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><products></products>');

        foreach ($products as $product) {
            $productXml = $xml->addChild('product');
            $productXml->addChild('title', htmlspecialchars($product->name));
            $productXml->addChild('price', $product->price);

            $categoriesXml = $productXml->addChild('categories');
            foreach ($product->categories as $category) {
                $categoriesXml->addChild('category', htmlspecialchars($category->name));
            }
        }

        return $xml->asXML();
    }
}
