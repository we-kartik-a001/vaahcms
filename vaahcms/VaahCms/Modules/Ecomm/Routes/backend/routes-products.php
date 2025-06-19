<?php

use VaahCms\Modules\Ecomm\Http\Controllers\Backend\ProductsController;

Route::group(
    [
        'prefix' => 'backend/ecomm/products',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [ProductsController::class, 'getAssets'])
        ->name('vh.backend.ecomm.products.assets');
    /**
     * Get List
     */
    Route::get('/', [ProductsController::class, 'getList'])
        ->name('vh.backend.ecomm.products.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ProductsController::class, 'updateList'])
        ->name('vh.backend.ecomm.products.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ProductsController::class, 'deleteList'])
        ->name('vh.backend.ecomm.products.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [ProductsController::class, 'fillItem'])
        ->name('vh.backend.ecomm.products.fill');

    /**
     * Create Item
     */
    Route::post('/', [ProductsController::class, 'createItem'])
        ->name('vh.backend.ecomm.products.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ProductsController::class, 'getItem'])
        ->name('vh.backend.ecomm.products.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ProductsController::class, 'updateItem'])
        ->name('vh.backend.ecomm.products.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ProductsController::class, 'deleteItem'])
        ->name('vh.backend.ecomm.products.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ProductsController::class, 'listAction'])
        ->name('vh.backend.ecomm.products.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ProductsController::class, 'itemAction'])
        ->name('vh.backend.ecomm.products.item.action');

    //---------------------------------------------------------

});
