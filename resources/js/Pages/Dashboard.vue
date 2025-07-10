<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import StatCard from '@/Components/Dashboard/StatCard.vue';
import RecentArticlesCard from '@/Components/Dashboard/RecentArticlesCard.vue';
import RecentLettersCard from '@/Components/Dashboard/RecentLettersCard.vue';
import QuickActionsCard from '@/Components/Dashboard/QuickActionsCard.vue';

// Menerima props dari controller
const props = defineProps({
    stats: Object,
    recentArticles: Array,
    recentLetters: Array,
});

// Definisikan warna untuk setiap kartu statistik
const statColors = {
    articles: '#3B82F6',  // Biru
    residents: '#10B981', // Hijau
    letters: '#8B5CF6',   // Ungu
    users: '#F59E0B',      // Kuning
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Admin Desa
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <StatCard title="Total Artikel" :stat="stats.articles" :chart-color="statColors.articles" />
                    <StatCard title="Total Penduduk" :stat="stats.residents" :chart-color="statColors.residents" />
                    <StatCard title="Surat Masuk" :stat="stats.letters" :chart-color="statColors.letters" />
                    <StatCard title="Total Pengguna" :stat="stats.users" :chart-color="statColors.users" />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <div class="lg:col-span-3">
                        <RecentArticlesCard :articles="recentArticles" />
                    </div>

                    <div class="lg:col-span-1">
                        <RecentLettersCard :letters="recentLetters" />
                    </div>
                </div>

                <QuickActionsCard />
            </div>
        </div>
    </AppLayout>
</template>