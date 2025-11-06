<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFechaEventoRequest extends FormRequest
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
     * Reglas de validación para crear una fecha de evento.
     */
    public function rules(): array
    {
        return [
            'id_evento' => 'required|exists:evento,id_evento',
            'fecha' => 'required|date|after_or_equal:yesterday',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'id_evento.required' => 'El evento es obligatorio',
            'id_evento.exists' => 'El evento seleccionado no existe',
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date' => 'La fecha debe ser una fecha válida',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a ayer',
        ];
    }
}
