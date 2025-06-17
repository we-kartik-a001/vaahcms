<?php
use VaahCms\Modules\Product\Http\Controllers\Backend\ItemsController;
/*
 * API url will be: <base-url>/public/api/product/items
 */
Route::group(
    [
        'prefix' => 'product/items',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [ItemsController::class, 'getAssets'])
        ->name('vh.backend.product.api.items.assets');
    /**
     * Get List
     */
    Route::get('/', [ItemsController::class, 'getList'])
        ->name('vh.backend.product.api.items.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [ItemsController::class, 'updateList'])
        ->name('vh.backend.product.api.items.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [ItemsController::class, 'deleteList'])
        ->name('vh.backend.product.api.items.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [ItemsController::class, 'createItem'])
        ->name('vh.backend.product.api.items.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [ItemsController::class, 'getItem'])
        ->name('vh.backend.product.api.items.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [ItemsController::class, 'updateItem'])
        ->name('vh.backend.product.api.items.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [ItemsController::class, 'deleteItem'])
        ->name('vh.backend.product.api.items.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [ItemsController::class, 'listAction'])
        ->name('vh.backend.product.api.items.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [ItemsController::class, 'itemAction'])
        ->name('vh.backend.product.api.items.item.action');



});
