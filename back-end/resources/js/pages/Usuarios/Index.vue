<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Gestión de Usuarios</h1>

        <table class="min-w-full bg-white border">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Rol</th>
                    <th class="px-4 py-2">Carrera</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="u in usuarios" :key="u.id_usuarios">
                    <td class="px-4 py-2">{{ u.nombre }} {{ u.apellidos }}</td>
                    <td class="px-4 py-2">{{ u.usuario }}</td>
                    <td class="px-4 py-2">{{ u.rol?.descripcion }}</td>
                    <td class="px-4 py-2">{{ u.carrera ? u.carrera.descripcion : '—' }}</td>
                    <td class="px-4 py-2">
                        <Link :href="route('usuarios.edit', u.id_usuarios)"
                              class="text-blue-600 hover:underline">Editar</Link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    usuarios: Array
})
</script>
