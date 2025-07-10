<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <Link :href="route('articles.create')" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                Tulis Artikel Baru
            </Link>
            <Link :href="route('admin.profile.edit')" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Edit Profil Desa
            </Link>
            <Link href="#" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Kelola Pengguna
            </Link>
        </div>
    </div>
</template>