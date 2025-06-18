<?php
use VaahCms\Modules\Product\Http\Controllers\Backend\StaffsController;
/*
 * API url will be: <base-url>/public/api/product/staffs
 */
Route::group(
    [
        'prefix' => 'product/staffs',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [StaffsController::class, 'getAssets'])
        ->name('vh.backend.product.api.staffs.assets');
    /**
     * Get List
     */
    Route::get('/', [StaffsController::class, 'getList'])
        ->name('vh.backend.product.api.staffs.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [StaffsController::class, 'updateList'])
        ->name('vh.backend.product.api.staffs.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [StaffsController::class, 'deleteList'])
        ->name('vh.backend.product.api.staffs.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [StaffsController::class, 'createItem'])
        ->name('vh.backend.product.api.staffs.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [StaffsController::class, 'getItem'])
        ->name('vh.backend.product.api.staffs.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [StaffsController::class, 'updateItem'])
        ->name('vh.backend.product.api.staffs.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [StaffsController::class, 'deleteItem'])
        ->name('vh.backend.product.api.staffs.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [StaffsController::class, 'listAction'])
        ->name('vh.backend.product.api.staffs.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [StaffsController::class, 'itemAction'])
        ->name('vh.backend.product.api.staffs.item.action');



});
