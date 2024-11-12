<?php
namespace App\Http\Controllers;

use App\Services\XmlFeedService;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * @var XmlFeedService
     */
    protected XmlFeedService $xmlFeedService;

    /**
     * Constructor to initialize the XML feed service.
     *
     * @param XmlFeedService $xmlFeedService
     */
    public function __construct(XmlFeedService $xmlFeedService)
    {
        $this->xmlFeedService = $xmlFeedService;
    }

    /**
     * Generate and return an XML feed of products.
     *
     * @return Response
     */
    public function generateXmlFeed(): Response
    {
        $xmlContent = $this->xmlFeedService->generateXmlFeed();

        return response($xmlContent, 200)
            ->header('Content-Type', 'application/xml');
    }
}
