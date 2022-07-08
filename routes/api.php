<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\ContactController;

Route::apiResources([
    '/contacts' => ContactController::class,
    '/companies' => CompanyController::class
]);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
