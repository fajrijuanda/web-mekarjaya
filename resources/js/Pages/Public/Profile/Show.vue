<script setup>
defineProps({
    settings: Object,
});
</script>

<template>
    <div class="font-sans text-gray-900 antialiased">
        <div class="max-w-4xl mx-auto p-8">
            <h1 class="text-4xl font-bold mb-8">Profil Desa</h1>

            <section class="mb-12">
                <h2 class="text-2xl font-semibold border-b pb-2 mb-4">Sejarah Desa</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ settings.village_history }}</p>
            </section>

            <section class="mb-12">
                <h2 class="text-2xl font-semibold border-b pb-2 mb-4">Visi</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ settings.village_vision }}</p>
            </section>

            <section>
                <h2 class="text-2xl font-semibold border-b pb-2 mb-4">Misi</h2>
                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ settings.village_mission }}</p>
            </section>
        </div>
    </div>
</template>