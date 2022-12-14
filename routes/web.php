<?php

use App\Http\Controllers\Apps\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login');
});

Route::prefix("apps")->group(function() {
    Route::group(["middleware" => ["auth"]], function() {
        Route::get("/dashboard", DashboardController::class)->name("apps.dashboard");

        Route::get("/permissions", \App\Http\Controllers\Apps\PermissionController::class)->name("apps.permissions.index")->middleware("permission:permissions.index");

        Route::resource("/roles", \App\Http\Controllers\Apps\RoleController::class, ["as" => "apps"])
        ->middleware("permission:roles.index|roles.create|roles.edit|roles.delete");

        Route::resource('/users', \App\Http\Controllers\Apps\UserController::class, ['as' => 'apps'])
        ->middleware('permission:users.index|users.create|users.edit|users.delete');

        Route::resource('/categories', \App\Http\Controllers\Apps\CategoryController::class, ['as' => 'apps'])
        ->middleware('permission:categories.index|categories.create|categories.edit|categories.delete');

        Route::resource('/products', \App\Http\Controllers\Apps\ProductController::class, ['as' => 'apps'])
        ->middleware('permission:products.index|products.create|products.edit|products.delete');

        Route::resource('/customers', \App\Http\Controllers\Apps\CustomerController::class, ['as' => 'apps'])
        ->middleware('permission:customers.index|customers.create|customers.edit|customers.delete');
    });
});