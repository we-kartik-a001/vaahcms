<?php

use VaahCms\Modules\Product\Http\Controllers\Backend\StaffsController;

Route::group(
    [
        'prefix' => 'backend/product/staffs',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [StaffsController::class, 'getAssets'])
        ->name('vh.backend.product.staffs.assets');
    /**
     * Get List
     */
    Route::get('/', [StaffsController::class, 'getList'])
        ->name('vh.backend.product.staffs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [StaffsController::class, 'updateList'])
        ->name('vh.backend.product.staffs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [StaffsController::class, 'deleteList'])
        ->name('vh.backend.product.staffs.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [StaffsController::class, 'fillItem'])
        ->name('vh.backend.product.staffs.fill');

    /**
     * Create Item
     */
    Route::post('/', [StaffsController::class, 'createItem'])
        ->name('vh.backend.product.staffs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [StaffsController::class, 'getItem'])
        ->name('vh.backend.product.staffs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [StaffsController::class, 'updateItem'])
        ->name('vh.backend.product.staffs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [StaffsController::class, 'deleteItem'])
        ->name('vh.backend.product.staffs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [StaffsController::class, 'listAction'])
        ->name('vh.backend.product.staffs.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [StaffsController::class, 'itemAction'])
        ->name('vh.backend.product.staffs.item.action');

    //---------------------------------------------------------

});
