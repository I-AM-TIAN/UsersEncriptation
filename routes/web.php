<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",[UsersController::class,"index"])->name("users.index");

//Ruta para añadir nuevo usuario
Route::post("/registrar-producto",[UsersController::class,"create"])->name("users.create");

//Ruta para modificar un producto
Route::post("/modificar-producto",[UsersController::class,"update"])->name("users.update");

//Ruta para eliminar un producto
Route::get("/eliminar-producto-{id}",[UsersController::class,"delete"])->name("users.delete");