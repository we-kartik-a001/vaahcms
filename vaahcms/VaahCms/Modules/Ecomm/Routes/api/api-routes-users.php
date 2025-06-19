<?php
use VaahCms\Modules\Ecomm\Http\Controllers\Backend\UsersController;
/*
 * API url will be: <base-url>/public/api/ecomm/users
 */
Route::group(
    [
        'prefix' => 'ecomm/users',
        'namespace' => 'Backend',
    ],
function () {

    /**
     * Get Assets
     */
    Route::get('/assets', [UsersController::class, 'getAssets'])
        ->name('vh.backend.ecomm.api.users.assets');
    /**
     * Get List
     */
    Route::get('/', [UsersController::class, 'getList'])
        ->name('vh.backend.ecomm.api.users.list');
    /**
     * Update List
     */
    Route::match(['put', 'patch'], '/', [UsersController::class, 'updateList'])
        ->name('vh.backend.ecomm.api.users.list.update');
    /**
     * Delete List
     */
    Route::delete('/', [UsersController::class, 'deleteList'])
        ->name('vh.backend.ecomm.api.users.list.delete');


    /**
     * Create Item
     */
    Route::post('/', [UsersController::class, 'createItem'])
        ->name('vh.backend.ecomm.api.users.create');
    /**
     * Get Item
     */
    Route::get('/{id}', [UsersController::class, 'getItem'])
        ->name('vh.backend.ecomm.api.users.read');
    /**
     * Update Item
     */
    Route::match(['put', 'patch'], '/{id}', [UsersController::class, 'updateItem'])
        ->name('vh.backend.ecomm.api.users.update');
    /**
     * Delete Item
     */
    Route::delete('/{id}', [UsersController::class, 'deleteItem'])
        ->name('vh.backend.ecomm.api.users.delete');

    /**
     * List Actions
     */
    Route::any('/action/{action}', [UsersController::class, 'listAction'])
        ->name('vh.backend.ecomm.api.users.list.action');

    /**
     * Item actions
     */
    Route::any('/{id}/action/{action}', [UsersController::class, 'itemAction'])
        ->name('vh.backend.ecomm.api.users.item.action');



});
