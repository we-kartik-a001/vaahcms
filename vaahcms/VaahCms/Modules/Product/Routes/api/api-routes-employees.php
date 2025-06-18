<?php
use VaahCms\Modules\Product\Http\Controllers\Backend\EmployeesController;
/*
 * API url will be: <base-url>/public/api/product/employees
 */
Route::group(
    [
        'prefix' => 'product/employees',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [EmployeesController::class, 'getAssets'])
        ->name('vh.backend.product.api.employees.assets');
    /**
     * Get List
     */
    Route::get('/', [EmployeesController::class, 'getList'])
        ->name('vh.backend.product.api.employees.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [EmployeesController::class, 'updateList'])
        ->name('vh.backend.product.api.employees.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [EmployeesController::class, 'deleteList'])
        ->name('vh.backend.product.api.employees.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [EmployeesController::class, 'createItem'])
        ->name('vh.backend.product.api.employees.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [EmployeesController::class, 'getItem'])
        ->name('vh.backend.product.api.employees.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [EmployeesController::class, 'updateItem'])
        ->name('vh.backend.product.api.employees.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [EmployeesController::class, 'deleteItem'])
        ->name('vh.backend.product.api.employees.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [EmployeesController::class, 'listAction'])
        ->name('vh.backend.product.api.employees.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [EmployeesController::class, 'itemAction'])
        ->name('vh.backend.product.api.employees.item.action');



});
