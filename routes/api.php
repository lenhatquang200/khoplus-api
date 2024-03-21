<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(
  ['prefix' => 'auth'],
  function () {
      Route::post('login', [AuthController::class, 'login']);
  }
);
Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('customer-groups', App\Http\Controllers\API\CustomerGroupAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('customers', App\Http\Controllers\API\CustomerAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('plants', App\Http\Controllers\API\PlantAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('customer-farms', App\Http\Controllers\API\CustomerFarmAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('manufacturing-groups', App\Http\Controllers\API\ManufacturingGroupAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('manufacturings', App\Http\Controllers\API\ManufacturingAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('products', App\Http\Controllers\API\ProductAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('product-units', App\Http\Controllers\API\ProductUnitAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('product-types', App\Http\Controllers\API\ProductTypeAPIController::class)
      ->except(['create', 'edit']);

    Route::resource('product-groups', App\Http\Controllers\API\ProductGroupAPIController::class)
      ->except(['create', 'edit']);
    Route::group(['prefix' => 'address'], function () {
        Route::get('get-provinces', [AddressController::class, 'getProvince']);
        Route::get('get-districts', [AddressController::class, 'getDistrict']);
        Route::get('get-wards', [AddressController::class, 'getWard']);
    });
    Route::resource('branches', App\Http\Controllers\API\BranchAPIController::class)
      ->except(['create', 'edit']);
});





Route::resource('customer-farms', App\Http\Controllers\API\CustomerFarmAPIController::class)
    ->except(['create', 'edit']);