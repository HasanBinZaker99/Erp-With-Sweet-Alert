<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CRM\CartController;

use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\MenuPermission\MenuPermissionController;

use App\Http\Controllers\CRM\QuotationController;
use App\Http\Controllers\CRM\MeasureController;
use App\Http\Controllers\Purchase\PurchaseController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();


});
Route::get('/quotations',[CartController::class,'getQuotations'])->name('quotations');
Route::get('/houseTypes',[CartController::class,'getHouseTypes'])->name('houseTypes');
Route::get('/decorTypes',[CartController::class,'getDecorTypes'])->name('decorTypes');
Route::get('/description',[CartController::class,'getDescription'])->name('description');
Route::get('/sub',[CartController::class,'getSubject'])->name('sub');
Route::post('/create-cart',[QuotationController::class,'createCart'])->name('create-cart');

Route::get('/measureTypes',[MeasureController::class,'getMeasureTypes'])->name('measureTypes');
Route::get('/measure-struct',[MeasureController::class,'getMeasureStruct'])->name('measure-struct');
Route::get('/rate',[MeasureController::class,'getRate'])->name('rate');

Route::post('/create-measure-cart',[MeasureController::class,'createMeasureCart'])->name('create-measure-cart');

Route::get('/menuList',[MenuController::class,'menuApi'])->name('menu');
Route::post('/submenu-req',[MenuController::class,'submenuReq'])->name('submenuReq');

Route::get('/userlist',[UserController::class,'userlistApi'])->name('user');

Route::post('/menu-permission',[MenuPermissionController::class,'givepermission'])->name('menupermission');

//for purchase
Route::get('/table-data',[PurchaseController::class,'getTables'])->name('table-data');
Route::get('/client-data',[PurchaseController::class,'getClients'])->name('client-data');
Route::get('/product-data',[PurchaseController::class,'getProducts'])->name('product-data');

Route::get('/user-data', [PurchaseController::class, 'getAuth'])->name('user-data');


