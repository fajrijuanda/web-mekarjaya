<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

// Menerima data yang dikirim dari backend
const props = defineProps({
    stats: Object,
    recentArticles: Array,
});

// Opsi dasar untuk semua grafik sparkline kita
const chartOptions = {
    chart: {
        type: 'area',
        height: 100,
        sparkline: {
            enabled: true,
        },
    },
    stroke: {
        curve: 'smooth',
        width: 2,
    },
    fill: {
        opacity: 0.3,
    },
    yaxis: {
        min: 0,
    },
    tooltip: {
        fixed: {
            enabled: false,
        },
        x: {
            show: false,
        },
        y: {
            title: {
                formatter: () => 'New',
            },
        },
        marker: {
            show: false,
        },
    },
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Total Artikel</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.articles?.total }}</p>
                        <div class="mt-4">
                            <VueApexCharts :options="chartOptions" :series="[{ data: stats.articles?.series }]" />
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Total Penduduk</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.residents?.total }}</p>
                        <div class="mt-4">
                            <VueApexCharts :options="chartOptions" :series="[{ data: stats.residents?.series }]" />
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Surat Masuk</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.letters?.total }}</p>
                        <div class="mt-4">
                            <VueApexCharts :options="chartOptions" :series="[{ data: stats.letters?.series }]" />
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                        <p class="text-sm font-medium text-gray-500 truncate">Total Pengguna</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ stats.users?.total }}</p>
                        <div class="mt-4">
                            <VueApexCharts :options="chartOptions" :series="[{ data: stats.users?.series }]" />
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Artikel Terbaru</h3>
                            </div>
                            <ul role="list" class="divide-y divide-gray-200">
                                <li v-for="article in recentArticles" :key="article.id"
                                    class="p-6 flex items-center justify-between hover:bg-gray-50">
                                    <div>
                                        <Link :href="route('articles.edit', article.id)"
                                            class="text-md font-semibold text-indigo-600 hover:underline">
                                        {{ article.title }}
                                        </Link>
                                        <p class="text-sm text-gray-500">
                                            oleh {{ article.user.name }} - <span
                                                :class="article.status === 'published' ? 'text-green-600' : 'text-yellow-600'">{{
                                                    article.status }}</span>
                                        </p>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ new
                                        Date(article.created_at).toLocaleDateString()
                                        }}</span>
                                </li>
                                <li v-if="recentArticles.length === 0" class="p-6 text-center text-gray-500">
                                    Belum ada artikel.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="space-y-4">
                                <Link :href="route('articles.create')"
                                    class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Tulis Artikel Baru
                                </Link>
                                <Link :href="route('admin.profile.edit')"
                                    class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Edit Profil Desa
                                </Link>
                                <Link href="#"
                                    class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Kelola Pengguna
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>