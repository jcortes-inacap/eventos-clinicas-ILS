<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLugarRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta petición.
     */
    public function authorize(): bool
    {
        // TODO: Agregar lógica de autorización
        // Por ejemplo: return auth()->user()->hasRole('Administrador');
        return true;
    }

    /**
     * Reglas de validación para actualizar un lugar.
     */
    public function rules(): array
    {
        return [
            'nombre' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('lugar', 'nombre')->ignore($this->route('lugar'), 'id_lugar')
            ],
            'direccion' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|string|max:60',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del lugar es obligatorio',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres',
            'nombre.unique' => 'Ya existe un lugar con ese nombre',
            'direccion.required' => 'La dirección del lugar es obligatoria',
            'direccion.max' => 'La dirección no puede exceder los 255 caracteres',
            'tipo.required' => 'El tipo de lugar es obligatorio',
            'tipo.max' => 'El tipo no puede exceder los 60 caracteres',
        ];
    }
}
