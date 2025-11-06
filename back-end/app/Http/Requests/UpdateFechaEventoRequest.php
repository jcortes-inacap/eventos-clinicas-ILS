<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFechaEventoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool
    {
        // TODO: Verificar que el usuario tenga permisos para modificar la fecha
        return true;
    }

    /**
     * Reglas de validación para actualizar una fecha de evento.
     */
    public function rules(): array
    {
        return [
            'id_evento' => 'sometimes|required|exists:evento,id_evento',
            'fecha' => 'sometimes|required|date|after_or_equal:yesterday',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'id_evento.exists' => 'El evento seleccionado no existe',
            'fecha.date' => 'La fecha debe ser una fecha válida',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a ayer',
        ];
    }
}
