<?php
namespace App\Http\Controllers;

use App\Services\XmlFeedService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    protected $xmlFeedService;

    public function __construct(XmlFeedService $xmlFeedService)
    {
        $this->xmlFeedService = $xmlFeedService;
    }

    public function generateXmlFeed(): Response
    {
        $xmlContent = $this->xmlFeedService->generateXmlFeed();

        return response($xmlContent, 200)
            ->header('Content-Type', 'application/xml');
    }
}
