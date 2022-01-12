<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login',[\App\Http\Controllers\UserController::class,'login']);
Route::post('/register',[\App\Http\Controllers\UserController::class,'register']);
Route::resource('/unit',\App\Http\Controllers\UnitController::class);
Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::post('/logout',[\App\Http\Controllers\UserController::class,'logout']);
    Route::post('/me',[\App\Http\Controllers\UserController::class,'me']);
    Route::put('/pass/{user}',[\App\Http\Controllers\UserController::class,'pass']);
    Route::put('/updatepermisos/{user}',[\App\Http\Controllers\UserController::class,'updatepermisos']);

    Route::resource('/user',\App\Http\Controllers\UserController::class);
    //Route::resource('/mail',\App\Http\Controllers\MailController::class);
    //Route::resource('/log',\App\Http\Controllers\LogController::class);
    //Route::resource('/asignacion',\App\Http\Controllers\AsignacionController::class);
    //Route::post('/updatemail',[\App\Http\Controllers\MailController::class,'updatemail']);
    //Route::post('/micorre',[\App\Http\Controllers\MailController::class,'micorre']);
    //Route::post('/buscar',[\App\Http\Controllers\MailController::class,'buscar']);
    //Route::post('/dividir',[\App\Http\Controllers\MailController::class,'dividir']);
    //Route::post('/anulado',[\App\Http\Controllers\MailController::class,'anulado']);
    //Route::post('/archivar',[\App\Http\Controllers\MailController::class,'archivar']);
    //Route::post('/aceptar',[\App\Http\Controllers\MailController::class,'aceptar']);
    Route::post('/misremetentes',[\App\Http\Controllers\UserController::class,'misremetentes']);
    Route::post('/usuarios',[\App\Http\Controllers\UserController::class,'usuarios']);
    //Route::post('/consulta',[\App\Http\Controllers\MailController::class,'consulta']);
    //Route::get('/todos',[\App\Http\Controllers\MailController::class,'todos']);
    Route::resource('/permiso',\App\Http\Controllers\PermisoController::class);
    Route::resource('/categoria',\App\Http\Controllers\CategoriaController::class);
    Route::resource('/subcategoria',\App\Http\Controllers\SubcategoriaController::class);
    Route::resource('/documento',\App\Http\Controllers\DocumentoController::class);
    Route::resource('/prestamo',\App\Http\Controllers\PrestamoController::class);
    Route::post('/misprestamo',[\App\Http\Controllers\PrestamoController::class,'misprestamo']);
    //Route::post('/upload',[\App\Http\Controllers\MailController::class,'upload']);
    Route::post('/uparchivo',[\App\Http\Controllers\DocumentoController::class,'uparchivo']);
    Route::post('/consulta',[\App\Http\Controllers\DocumentoController::class,'consulta']);
    Route::post('/concategoria',[\App\Http\Controllers\DocumentoController::class,'concategoria']);
    Route::post('/concategoria',[\App\Http\Controllers\DocumentoController::class,'concategoria']);
    Route::post('/reporte',[\App\Http\Controllers\DocumentoController::class,'reporte']);
    Route::post('/repcategoria',[\App\Http\Controllers\DocumentoController::class,'repcategoria']);
    Route::post('/repprestamo',[\App\Http\Controllers\DocumentoController::class,'repprestamo']);
    Route::post('/totales',[\App\Http\Controllers\DocumentoController::class,'totales']);
    Route::post('/conprestamo',[\App\Http\Controllers\PrestamoController::class,'conprestamo']);
    Route::post('/reporte',[\App\Http\Controllers\DocumentoController::class,'reporte']);
});
    //Route::get('/mail/{mail}/{user}',[\App\Http\Controllers\MailController::class,'show']);

