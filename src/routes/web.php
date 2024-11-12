<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/products/xml-feed', [ProductController::class, 'generateXmlFeed']);
