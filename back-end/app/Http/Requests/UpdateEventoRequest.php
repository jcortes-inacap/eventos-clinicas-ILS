<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventoRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool
    {
        // TODO: Verificar que el usuario sea el creador o administrador
        // return $this->route('evento')->id_usuarios === auth()->id() || auth()->user()->isAdmin();
        return true;
    }

    /**
     * Reglas de validación para actualizar un evento.
     */
    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|required|string|max:200',
            'descripcion' => 'nullable|string',
            'afiche_grafico' => 'nullable|string|max:255',
            'visibilidad' => 'sometimes|required|in:publico,privado,interno',
            'modalidad' => 'sometimes|required|in:presencial,online,hibrida',
            'qr_url' => 'nullable|string|max:255',
            'requiere_estacionamiento' => 'boolean',
            'duracion' => 'nullable|integer|min:1',
            'id_lugar' => 'nullable|exists:lugar,id_lugar',
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
            'visibilidad.in' => 'La visibilidad debe ser: publico, privado o interno',
            'modalidad.in' => 'La modalidad debe ser: presencial, online o hibrida',
            'duracion.min' => 'La duración debe ser al menos 1 minuto',
            'id_lugar.exists' => 'El lugar seleccionado no existe',
        ];
    }
}
