<?php

use VaahCms\Modules\Product\Http\Controllers\Backend\BrandsController;

Route::group(
    [
        'prefix' => 'backend/product/brands',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [BrandsController::class, 'getAssets'])
        ->name('vh.backend.product.brands.assets');
    /**
     * Get List
     */
    Route::get('/', [BrandsController::class, 'getList'])
        ->name('vh.backend.product.brands.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [BrandsController::class, 'updateList'])
        ->name('vh.backend.product.brands.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [BrandsController::class, 'deleteList'])
        ->name('vh.backend.product.brands.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [BrandsController::class, 'fillItem'])
        ->name('vh.backend.product.brands.fill');

    /**
     * Create Item
     */
    Route::post('/', [BrandsController::class, 'createItem'])
        ->name('vh.backend.product.brands.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [BrandsController::class, 'getItem'])
        ->name('vh.backend.product.brands.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [BrandsController::class, 'updateItem'])
        ->name('vh.backend.product.brands.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [BrandsController::class, 'deleteItem'])
        ->name('vh.backend.product.brands.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [BrandsController::class, 'listAction'])
        ->name('vh.backend.product.brands.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [BrandsController::class, 'itemAction'])
        ->name('vh.backend.product.brands.item.action');

    //---------------------------------------------------------

});
