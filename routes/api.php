<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SchemaController;
use App\Http\Controllers\Admin\TenantController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(["prefix" => "plans"], function () {
    Route::get("/", [SchemaController::class, "list_for_api"])->name("list_for_api.schema");
});

Route::post("admin/tenant-management/register_tenant", [TenantController::class, "register_for_api"])->name("api.admin.tenant_management.register_tenant");
