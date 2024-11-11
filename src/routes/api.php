<?php

use App\Http\Controllers\ProductController;

Route::get('/products/xml-feed', [ProductController::class, 'generateXmlFeed']);

