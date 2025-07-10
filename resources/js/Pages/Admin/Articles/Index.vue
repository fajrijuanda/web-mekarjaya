<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
    articles: Object,
});

const deleteArticle = (id) => {
    if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
        router.delete(route('articles.destroy', id));
    }
};
</script>

<template>
    <AppLayout title="Daftar Artikel">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Manajemen Artikel
                </h2>
                <Link :href="route('articles.create')" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                    Buat Artikel Baru
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="p-4">Judul</th>
                                <th class="p-4">Author</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="article in articles.data" :key="article.id" class="border-b">
                                <td class="p-4">{{ article.title }}</td>
                                <td class="p-4">{{ article.user.name }}</td>
                                <td class="p-4">
                                    <span :class="article.status === 'published' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800'" class="px-2 py-1 text-xs font-semibold rounded-full">
                                        {{ article.status }}
                                    </span>
                                </td>
                                <td class="p-4 space-x-2">
                                    <Link :href="route('articles.edit', article.id)" class="text-blue-600 hover:underline">Edit</Link>
                                    <button @click="deleteArticle(article.id)" class="text-red-600 hover:underline">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
    </AppLayout>
</template>