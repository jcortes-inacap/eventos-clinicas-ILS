<template>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>

        <form @submit.prevent="submit" class="space-y-4 bg-white p-4 rounded shadow">
            <div>
                <label class="block text-gray-700">Nombre</label>
                <input type="text" v-model="form.nombre" class="border p-2 w-full rounded bg-gray-100" />
            </div>

            <div>
                <label class="block text-gray-700">Rol</label>
                <select v-model="form.id_roles" class="border p-2 w-full rounded">
                    <option v-for="r in roles" :key="r.id_roles" :value="r.id_roles">
                        {{ r.descripcion }}
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700">Carrera</label>
                <select v-model="form.id_carrera" class="border p-2 w-full rounded">
                    <option value="">— Ninguna —</option>
                    <option v-for="c in carreras" :key="c.id_carrera" :value="c.id_carrera">
                        {{ c.descripcion }}
                    </option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 rounded hover:bg-blue-700">
                Guardar cambios
            </button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    usuario: Object,
    roles: Array,
    carreras: Array
})

const form = useForm({
    id_roles: props.usuario.id_roles ?? '',
    id_carrera: props.usuario.id_carrera ?? '',
    nombre: props.usuario.nombre ?? '' // Agregamos el campo nombres
})

const submit = () => {
    form.put(route('usuarios.update', props.usuario.id_usuarios))
}
</script>
