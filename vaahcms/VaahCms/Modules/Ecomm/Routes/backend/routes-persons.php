<?php

use VaahCms\Modules\Ecomm\Http\Controllers\Backend\PersonsController;

Route::group(
    [
        'prefix' => 'backend/ecomm/persons',
        
        'middleware' => ['web', 'has.backend.access'],
        
],
function () {
    /**
     * Get Assets
     */

    Route::get('/assets', [PersonsController::class, 'getAssets'])
        ->name('vh.backend.ecomm.persons.assets');
    /**
     * Get List
     */
    Route::get('/', [PersonsController::class, 'getList'])
        ->name('vh.backend.ecomm.persons.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [PersonsController::class, 'updateList'])
        ->name('vh.backend.ecomm.persons.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [PersonsController::class, 'deleteList'])
        ->name('vh.backend.ecomm.persons.list.delete');


    /**
     * Fill Form Inputs
     */
    Route::any('/fill', [PersonsController::class, 'fillItem'])
        ->name('vh.backend.ecomm.persons.fill');

    /**
     * Create Item
     */
    Route::post('/', [PersonsController::class, 'createItem'])
        ->name('vh.backend.ecomm.persons.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [PersonsController::class, 'getItem'])
        ->name('vh.backend.ecomm.persons.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [PersonsController::class, 'updateItem'])
        ->name('vh.backend.ecomm.persons.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [PersonsController::class, 'deleteItem'])
        ->name('vh.backend.ecomm.persons.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [PersonsController::class, 'listAction'])
        ->name('vh.backend.ecomm.persons.list.actions');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [PersonsController::class, 'itemAction'])
        ->name('vh.backend.ecomm.persons.item.action');

    //---------------------------------------------------------

});
