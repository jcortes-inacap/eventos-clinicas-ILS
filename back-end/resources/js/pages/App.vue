<template>
    <div class="min-h-screen bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-white shadow-sm border-b">
            <div class="container mx-auto px-6 py-4 flex gap-6">
                <Link href="/" class="text-blue-600 hover:text-blue-800" prefetch>Inicio</Link>
                <Link href="/usuarios" class="text-blue-600 hover:text-blue-800" prefetch>Usuarios</Link>
            </div>
        </nav>

        <!-- Contenido dinámico de cada página -->
        <main class="py-8">
            <div class="container mx-auto px-6">
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>
