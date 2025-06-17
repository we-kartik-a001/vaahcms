<?php

use VaahCms\Modules\Product\Http\Controllers\Backend\ItemsController;

Route::group(
    [
        'prefix' => 'backend/product/items',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [ItemsController::class, 'getAssets'])
        ->name('vh.backend.product.items.assets');
    /**
     * Get List
     */
    Route::get('/', [ItemsController::class, 'getList'])
        ->name('vh.backend.product.items.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ItemsController::class, 'updateList'])
        ->name('vh.backend.product.items.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ItemsController::class, 'deleteList'])
        ->name('vh.backend.product.items.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [ItemsController::class, 'fillItem'])
        ->name('vh.backend.product.items.fill');

    /**
     * Create Item
     */
    Route::post('/', [ItemsController::class, 'createItem'])
        ->name('vh.backend.product.items.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ItemsController::class, 'getItem'])
        ->name('vh.backend.product.items.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ItemsController::class, 'updateItem'])
        ->name('vh.backend.product.items.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ItemsController::class, 'deleteItem'])
        ->name('vh.backend.product.items.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ItemsController::class, 'listAction'])
        ->name('vh.backend.product.items.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ItemsController::class, 'itemAction'])
        ->name('vh.backend.product.items.item.action');

    //---------------------------------------------------------

});
