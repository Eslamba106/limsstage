<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchemaController;

 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => "plans"], function () {
    Route::get("/", [SchemaController::class, "list_for_api"])->name("list_for_api.schema");
});
