<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool
    {
        // TODO: Agregar lógica de autorización
        // Por ejemplo: return auth()->user()->hasRole('Director de Carrera');
        return true;
    }

    /**
     * Reglas de validación para crear un evento.
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'afiche_grafico' => 'nullable|string|max:255',
            'visibilidad' => 'required|in:publico,privado,interno',
            'modalidad' => 'required|in:presencial,online,hibrida',
            'qr_url' => 'nullable|string|max:255',
            'requiere_estacionamiento' => 'boolean',
            'duracion' => 'nullable|integer|min:1',
            'id_lugar' => 'nullable|exists:lugar,id_lugar',
            'id_usuarios' => 'required|exists:usuarios,id_usuarios',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'El título del evento es obligatorio',
            'titulo.max' => 'El título no puede exceder los 200 caracteres',
            'visibilidad.required' => 'La visibilidad del evento es obligatoria',
            'visibilidad.in' => 'La visibilidad debe ser: publico, privado o interno',
            'modalidad.required' => 'La modalidad del evento es obligatoria',
            'modalidad.in' => 'La modalidad debe ser: presencial, online o hibrida',
            'duracion.min' => 'La duración debe ser al menos 1 minuto',
            'id_lugar.exists' => 'El lugar seleccionado no existe',
            'id_usuarios.required' => 'El usuario creador es obligatorio',
            'id_usuarios.exists' => 'El usuario seleccionado no existe',
        ];
    }
}
