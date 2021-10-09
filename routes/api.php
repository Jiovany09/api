<?php

use App\Http\Controllers\ArduinoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneradorController;
use App\Http\Controllers\ContenedorController;
use App\Http\Controllers\LamparaController;
use App\Http\Controllers\DetalleGeneradorController;
use App\Http\Controllers\DetalleContenedorController;
use App\Http\Controllers\GraficaGeneracionController;
use App\Http\Controllers\GraficaConsumoController;
use App\Http\Controllers\InfoTiempoRealController;

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

Route::post('register',[UserController::class, 'register']);
Route::post('login',[UserController::class, 'login']);

Route::get('listCitizen',[UserController::class, 'listCitizen']);
Route::get('listCitizenEliminate',[UserController::class, 'listCitizenEliminate']);
Route::put('editCitizen/{id}',[UserController::class, 'editCitizen']);

Route::post('createAdministrator',[UserController::class, 'createAdministrator']);
Route::get('listAdministrator',[UserController::class, 'listAdministrator']);
Route::get('listAdministratorEliminate',[UserController::class, 'listAdministratorEliminate']);

Route::post('createEmployee',[UserController::class, 'createEmployee']);
Route::get('listEmployee',[UserController::class, 'listEmployee']);
Route::get('listEmployeeEliminate',[UserController::class, 'listEmployeeEliminate']);

Route::put('edit/{id}',[UserController::class, 'edit']);
Route::delete('delete/{id}',[UserController::class, 'delete']);
Route::get('restore/{id}',[UserController::class, 'restore']);
Route::get('findUser/{id}',[UserController::class, 'findUser']);

Route::post('createGeneradores',[GeneradorController::class, 'createGeneradores']);
Route::get('listGeneradores',[GeneradorController::class, 'listGeneradores']);
Route::get('listGeneradoresEliminate',[GeneradorController::class, 'listGeneradoresEliminate']);
Route::put('editGeneradores/{id}',[GeneradorController::class, 'editGeneradores']);
Route::delete('eliminateGeneradores/{id}',[GeneradorController::class, 'eliminateGeneradores']);
Route::get('activarDesactivarGeneradores/{id}',[GeneradorController::class, 'activarDesactivar']);
Route::get('restoreGeneradores/{id}',[GeneradorController::class, 'restoreGeneradores']);
Route::get('findGenerador/{id}',[GeneradorController::class, 'findProtected']);

Route::post('createContenedores',[ContenedorController::class, 'createContenedores']);
Route::get('listContenedores',[ContenedorController::class, 'listContenedores']);
Route::get('listContenedoresEliminate',[ContenedorController::class, 'listContenedoresEliminate']);
Route::put('editContenedores/{id}',[ContenedorController::class, 'editContenedores']);
Route::delete('deleteContenedores/{id}',[ContenedorController::class, 'deleteContenedores']);
Route::get('activarDesactivarContenedores/{id}',[ContenedorController::class, 'activarDesactivarContenedores']);
Route::get('restoreContenedores/{id}',[ContenedorController::class, 'restoreContenedores']);
Route::get('findContenedor/{id}',[ContenedorController::class, 'findProtected']);

Route::get('prueba',[ContenedorController::class, 'prueba']);
Route::post('pruebaPost',[ContenedorController::class, 'pruebaPost']);

Route::post('createLampara',[LamparaController::class, 'createLampara']);
Route::get('listLamparas',[LamparaController::class, 'listLamparas']);
Route::get('listLamparasEliminate',[LamparaController::class, 'listLamparasEliminate']);
Route::get('listByContainer/{id}',[LamparaController::class, 'listByContainer']);
Route::put('editLamparas/{id}',[LamparaController::class, 'editLamparas']);
Route::delete('deleteLamparas/{id}',[LamparaController::class, 'deleteLamparas']);
Route::get('activarDesactivarLamparas/{id}',[LamparaController::class, 'activarDesactivarLamparas']);
Route::get('restoreLamparas/{id}',[LamparaController::class, 'restoreLamparas']);
Route::get('findLampara/{id}',[LamparaController::class, 'findProtected']);

Route::post('createDetalleGenerador',[DetalleGeneradorController::class, 'createDetalleGenerador']);
Route::get('listDetallesGeneradores',[DetalleGeneradorController::class, 'listDetallesGeneradores']);

Route::post('createDetalleContenedor',[DetalleContenedorController::class, 'createDetalleContenedor']);
Route::get('listDetallesContenedores',[DetalleContenedorController::class, 'listDetallesContenedores']);

Route::get('graficaGeneracionEnergia/{tipo}',[GraficaGeneracionController::class, 'listInfo']);
Route::get('graficaConsumoEnergia/{tipo}',[GraficaConsumoController::class, 'listInfo']);

Route::get('arduino/{serial}',[GeneradorController::class,'arduino']);

Route::get('statusGenerador/{serial}',[ArduinoController::class,'estadoGenerador']);
Route::get('statusContenedor/{serial}',[ArduinoController::class,'estadoContenedor']);
Route::get('statusLampara/{id}',[ArduinoController::class,'estadoLampara']);
Route::get('estadoConsultaInformacionWeb/{serial}',[ArduinoController::class,'estadoConsultaInformacionWeb']);
Route::get('estadoConsultaInformacionApp/{serial}',[ArduinoController::class,'estadoConsultaInformacionApp']);

Route::post('createInfoGenerador',[InfoTiempoRealController::class,'createInfoGenerador']);
Route::post('createInfoContenedor',[InfoTiempoRealController::class,'createInfoContenedor']);
Route::get('listInfoTiempoRealGenerador/{id}',[InfoTiempoRealController::class,'listInfoTiempoRealGenerador']);
Route::get('listInfoTiempoRealContenedor/{id}',[InfoTiempoRealController::class,'listInfoTiempoRealContenedor']);
Route::get('aumentarUsuarioGenerador/{serial}',[InfoTiempoRealController::class,'aumentarUsuarioGenerador']);
Route::get('decrementarUsuarioGenerador/{serial}',[InfoTiempoRealController::class,'decrementarUsuarioGenerador']);
Route::get('aumentarUsuarioContenedor/{serial}',[InfoTiempoRealController::class,'aumentarUsuarioContenedor']);
Route::get('decrementarUsuarioContenedor/{serial}',[InfoTiempoRealController::class,'decrementarUsuarioContenedor']);