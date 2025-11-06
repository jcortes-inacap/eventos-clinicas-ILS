<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CarreraController;
use App\Models\Usuario;
use App\Http\Controllers\UsuarioController;
use App\Models\Rol;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;



/*

    Controlador principal de la API

    metodos disponibles:
    - UsuarioController: showAll, showOne
    - AsignacionController: index, update
    - CatalogoController: roles, carreras, directoresCarrera

    (Ultima actualización: 15-09-2025)
*/


Route::prefix('usuarios')->group(function () {
    // Rutas adicionales para manejar usuarios inactivos y restauración
    Route::get('/usuarios-inactivos', [UsuarioController::class, 'showInactive']);
    Route::get('/usuarios-todos', [UsuarioController::class, 'showAllWithInactive']);
    Route::patch('/usuarios/{id}/restore', [UsuarioController::class, 'restore']);

    // Recursos de usuarios
    // esta ruta equivale a /api/usuarios/
    Route::get('/', [UsuarioController::class, 'showAll']);
    Route::get('/{usuario}', [UsuarioController::class, 'showOne']); // esta ruta equivale a /api/usuarios/{usuario} donde {usuario} es un ID, por ejemplo /api/usuarios/1
    Route::delete('/{usuario}', [UsuarioController::class, 'destroy']);


});

Route::prefix('asignaciones')->group(function() {
    // Recursos de asignaciones

    // esta ruta equivale a /api/asignaciones/{usuario} donde {usuario} es un ID, por ejemplo /api/asignaciones/13
    Route::put('/{usuario}', [AsignacionController::class, 'update']);
});

Route::prefix('catalogos')->group(function() {
    // Rutas para obtener opciones de formularios
    // TODO: Controlador CatalogoController para manejar estas rutas :)
    Route::get('/roles', function() {
        return Rol::where('estado', '!=', 0)->get();
    });

    Route::get('/carreras', function() {
        return Carrera::where('estado', '!=', 0)->get();
    });

    // obtener directores de carrera
    Route::get('/directores-carrera', function() {
        // obtener usuarios cuyo rol es 'Director de Carrera' y su carrera
        return Usuario::whereHas('rol', fn($q) => $q->where('descripcion', 'Director de Carrera'))->with(['carrera'])->get();
    });

    // TODO agregar más catálogos si es necesario, por ejemplo docentes, asistentes, etc...
});



///Rutas de Areas y Carreras
Route::apiResource('areas', AreaController::class);
Route::apiResource('carreras', CarreraController::class);
Route::post('/areas/{id}/toggle', [AreaController::class, 'toggleEstadoPorId']);
Route::post('/carreras/{id}/toggle', [CarreraController::class, 'toggle']);
Route::put('/api/areas/{id}', [AreaController::class, 'update']);
