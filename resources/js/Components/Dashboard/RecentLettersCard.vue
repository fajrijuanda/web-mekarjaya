<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    letters: Array,
});
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Surat Terbaru</h3>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="letter in letters" :key="letter.id" class="p-6 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="text-md font-semibold text-indigo-600">{{ letter.title }}</p>
                    <p class="text-sm text-gray-500">
                        No: {{ letter.letter_number }} - <span :class="letter.type === 'masuk' ? 'text-blue-600' : 'text-purple-600'">{{ letter.type }}</span>
                    </p>
                </div>
                <span class="text-sm text-gray-500">{{ new Date(letter.letter_date).toLocaleDateString() }}</span>
            </li>
            <li v-if="!letters || letters.length === 0" class="p-6 text-center text-gray-500">
                Belum ada surat.
            </li>
        </ul>
    </div>
</template>