<?php
use VaahCms\Modules\Ecomm\Http\Controllers\Backend\PersonsController;
/*
 * API url will be: <base-url>/public/api/ecomm/persons
 */
Route::group(
    [
        'prefix' => 'ecomm/persons',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [PersonsController::class, 'getAssets'])
        ->name('vh.backend.ecomm.api.persons.assets');
    /**
     * Get List
     */
    Route::get('/', [PersonsController::class, 'getList'])
        ->name('vh.backend.ecomm.api.persons.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [PersonsController::class, 'updateList'])
        ->name('vh.backend.ecomm.api.persons.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [PersonsController::class, 'deleteList'])
        ->name('vh.backend.ecomm.api.persons.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [PersonsController::class, 'createItem'])
        ->name('vh.backend.ecomm.api.persons.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [PersonsController::class, 'getItem'])
        ->name('vh.backend.ecomm.api.persons.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [PersonsController::class, 'updateItem'])
        ->name('vh.backend.ecomm.api.persons.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [PersonsController::class, 'deleteItem'])
        ->name('vh.backend.ecomm.api.persons.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [PersonsController::class, 'listAction'])
        ->name('vh.backend.ecomm.api.persons.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [PersonsController::class, 'itemAction'])
        ->name('vh.backend.ecomm.api.persons.item.action');



});
