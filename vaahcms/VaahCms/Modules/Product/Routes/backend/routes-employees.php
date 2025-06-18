<?php

use VaahCms\Modules\Product\Http\Controllers\Backend\EmployeesController;

Route::group(
    [
        'prefix' => 'backend/product/employees',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */
    Route::get('/assets', [EmployeesController::class, 'getAssets'])
        ->name('vh.backend.product.employees.assets');
    /**
     * Get List
     */
    Route::get('/', [EmployeesController::class, 'getList'])
        ->name('vh.backend.product.employees.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [EmployeesController::class, 'updateList'])
        ->name('vh.backend.product.employees.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [EmployeesController::class, 'deleteList'])
        ->name('vh.backend.product.employees.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [EmployeesController::class, 'fillItem'])
        ->name('vh.backend.product.employees.fill');

    /**
     * Create Item
     */
    Route::post('/', [EmployeesController::class, 'createItem'])
        ->name('vh.backend.product.employees.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [EmployeesController::class, 'getItem'])
        ->name('vh.backend.product.employees.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [EmployeesController::class, 'updateItem'])
        ->name('vh.backend.product.employees.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [EmployeesController::class, 'deleteItem'])
        ->name('vh.backend.product.employees.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [EmployeesController::class, 'listAction'])
        ->name('vh.backend.product.employees.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [EmployeesController::class, 'itemAction'])
        ->name('vh.backend.product.employees.item.action');

    //---------------------------------------------------------

});
