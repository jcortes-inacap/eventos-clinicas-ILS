<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\FechaEventoController;
use App\Http\Controllers\LugarController;
use App\Models\Usuario;
use App\Http\Controllers\UsuarioController;
use App\Models\Rol;
use App\Models\Carrera;

/*

    Controlador principal de la API

    metodos disponibles:
    - UsuarioController: showAll, showOne, destroy, showInactive, showAllWithInactive, restore
    - EventoController: index, show, store, update, destroy, filtrarPorVisibilidad, filtrarPorModalidad, misEventos
    - LugarController: index, show, store, update, destroy, filtrarPorTipo, buscarPorNombre, lugaresConEventos
    - AsignacionController: index, update
    - CatalogoController: roles, carreras, directoresCarrera

    (Ultima actualización: 22-10-2025)
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

// ============================================
// RUTAS DE EVENTOS (CRUD COMPLETO)
// ============================================
Route::prefix('eventos')->group(function() {

    // Rutas de filtrado (DEBEN IR ANTES de las rutas con parámetros)
    Route::get('/filtrar/visibilidad/{tipo}', [EventoController::class, 'filtrarPorVisibilidad']);
    Route::get('/filtrar/modalidad/{tipo}', [EventoController::class, 'filtrarPorModalidad']);
    
    // Eventos del usuario
    Route::get('/usuario/{idUsuario}', [EventoController::class, 'misEventos']);

    // Rutas básicas del CRUD con Route Model Binding
    Route::get('/', [EventoController::class, 'index']);                    // Listar todos los eventos activos
    Route::get('/{evento}', [EventoController::class, 'show']);             // Ver un evento específico (Route Model Binding)
    Route::post('/', [EventoController::class, 'store']);                   // Crear un nuevo evento
    Route::put('/{evento}', [EventoController::class, 'update']);           // Actualizar un evento (Route Model Binding)
    Route::patch('/{evento}', [EventoController::class, 'update']);         // Actualizar parcialmente un evento (Route Model Binding)
    Route::delete('/{evento}', [EventoController::class, 'destroy']);       // Eliminar un evento - soft delete (Route Model Binding)
});

// ============================================
// RUTAS DE LUGARES (CRUD COMPLETO)
// ============================================
Route::prefix('lugares')->group(function() {

    // Rutas especiales (DEBEN IR ANTES de las rutas con parámetros)
    Route::get('/con-eventos', [LugarController::class, 'lugaresConEventos']);
    Route::get('/filtrar/tipo/{tipo}', [LugarController::class, 'filtrarPorTipo']);
    Route::get('/buscar/{nombre}', [LugarController::class, 'buscarPorNombre']);

    // Rutas básicas del CRUD con Route Model Binding
    Route::get('/', [LugarController::class, 'index']);                     // Listar todos los lugares
    Route::get('/{lugar}', [LugarController::class, 'show']);               // Ver un lugar específico (Route Model Binding)
    Route::post('/', [LugarController::class, 'store']);                    // Crear un nuevo lugar
    Route::put('/{lugar}', [LugarController::class, 'update']);             // Actualizar un lugar (Route Model Binding)
    Route::patch('/{lugar}', [LugarController::class, 'update']);           // Actualizar parcialmente un lugar (Route Model Binding)
    Route::delete('/{lugar}', [LugarController::class, 'destroy']);         // Eliminar un lugar (solo si no tiene eventos)
});

// ============================================
// RUTAS DE FECHAS DE EVENTOS (CRUD COMPLETO)
// ============================================
Route::prefix('fechas-evento')->group(function() {

    // Rutas especiales (DEBEN IR ANTES de las rutas con parámetros)
    Route::get('/evento/{idEvento}', [FechaEventoController::class, 'fechasPorEvento']);

    // Rutas básicas del CRUD con Route Model Binding
    Route::get('/', [FechaEventoController::class, 'index']);                       // Listar todas las fechas de eventos
    Route::get('/{fechaEvento}', [FechaEventoController::class, 'show']);           // Ver una fecha específica (Route Model Binding)
    Route::post('/', [FechaEventoController::class, 'store']);                      // Crear una nueva fecha de evento
    Route::put('/{fechaEvento}', [FechaEventoController::class, 'update']);         // Actualizar una fecha (Route Model Binding)
    Route::patch('/{fechaEvento}', [FechaEventoController::class, 'update']);       // Actualizar parcialmente una fecha (Route Model Binding)
    Route::delete('/{fechaEvento}', [FechaEventoController::class, 'destroy']);     // Eliminar una fecha (eliminación física)
});
