<?php
use VaahCms\Modules\Product\Http\Controllers\Backend\BrandsController;
/*
 * API url will be: <base-url>/public/api/product/brands
 */
Route::group(
    [
        'prefix' => 'product/brands',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [BrandsController::class, 'getAssets'])
        ->name('vh.backend.product.api.brands.assets');
    /**
     * Get List
     */
    Route::get('/', [BrandsController::class, 'getList'])
        ->name('vh.backend.product.api.brands.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [BrandsController::class, 'updateList'])
        ->name('vh.backend.product.api.brands.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [BrandsController::class, 'deleteList'])
        ->name('vh.backend.product.api.brands.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [BrandsController::class, 'createItem'])
        ->name('vh.backend.product.api.brands.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [BrandsController::class, 'getItem'])
        ->name('vh.backend.product.api.brands.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [BrandsController::class, 'updateItem'])
        ->name('vh.backend.product.api.brands.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [BrandsController::class, 'deleteItem'])
        ->name('vh.backend.product.api.brands.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [BrandsController::class, 'listAction'])
        ->name('vh.backend.product.api.brands.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [BrandsController::class, 'itemAction'])
        ->name('vh.backend.product.api.brands.item.action');



});
