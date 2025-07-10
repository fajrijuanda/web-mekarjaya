<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    articles: Object,
});
</script>

<template>
    <div class="bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Artikel Terbaru</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="article in articles.data" :key="article.id" class="bg-white rounded-lg shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ article.title }}</h2>
                        <p class="text-sm text-gray-500 mb-4">
                            Oleh {{ article.user.name }} - {{ new Date(article.created_at).toLocaleDateString() }}
                        </p>
                        <Link :href="route('articles.public.show', article.slug)" class="font-semibold text-blue-600 hover:text-blue-800">
                            Baca Selengkapnya &rarr;
                        </Link>
                    </div>
                </div>
            </div>

            </div>
    </div>
</template>