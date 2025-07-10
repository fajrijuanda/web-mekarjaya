<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    articles: Array,
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Artikel Terbaru</h3>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="article in articles" :key="article.id" class="p-6 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <Link :href="route('articles.edit', article.id)" class="text-md font-semibold text-indigo-600 hover:underline">
                        {{ article.title }}
                    </Link>
                    <p class="text-sm text-gray-500">
                        oleh {{ article.user.name }} - <span :class="article.status === 'published' ? 'text-green-600' : 'text-yellow-600'">{{ article.status }}</span>
                    </p>
                </div>
                <span class="text-sm text-gray-500">{{ new Date(article.created_at).toLocaleDateString() }}</span>
            </li>
            <li v-if="!articles || articles.length === 0" class="p-6 text-center text-gray-500">
                Belum ada artikel.
            </li>
        </ul>
    </div>
</template>