<script setup>
import { computed, defineProps } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

// Komponen ini menerima data sebagai props
const props = defineProps({
    title: String,
    stat: Object,
    chartColor: {
        type: String,
        default: '#4f46e5', // Warna default (indigo)
    }
});

// Opsi grafik dibuat secara dinamis berdasarkan props
const chartOptions = computed(() => ({
    chart: { type: 'area', height: 100, sparkline: { enabled: true } },
    stroke: { curve: 'smooth', width: 2 },
    fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.1 } },
    colors: [props.chartColor], // <-- Menggunakan warna dari props
    yaxis: { min: 0 },
    tooltip: { enabled: false }
}));
</script>

<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
        <p class="text-sm font-medium text-gray-500 truncate">{{ title }}</p>
        <div class="flex items-baseline justify-between">
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ stat?.total }}</p>
            
            <div v-if="stat?.fluctuation !== undefined" class="flex items-center text-sm font-semibold" :class="{ 'text-green-600': stat?.fluctuation > 0, 'text-red-600': stat?.fluctuation < 0, 'text-gray-500': stat?.fluctuation === 0 }">
                <svg v-if="stat?.fluctuation > 0" class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.28 9.68a.75.75 0 01-1.06-1.06l5.25-5.25a.75.75 0 011.06 0l5.25 5.25a.75.75 0 11-1.06 1.06L10.75 5.612V16.25A.75.75 0 0110 17z" clip-rule="evenodd" /></svg>
                <svg v-else-if="stat?.fluctuation < 0" class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v10.638l3.97-3.968a.75.75 0 111.06 1.06l-5.25 5.25a.75.75 0 01-1.06 0l-5.25-5.25a.75.75 0 111.06-1.06l3.97 3.968V3.75A.75.75 0 0110 3z" clip-rule="evenodd" /></svg>
                <svg v-else class="h-5 w-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h12.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z" clip-rule="evenodd" /></svg>
                
                <span class="ml-1">{{ Math.abs(stat?.fluctuation) }}%</span>
                <span class="ml-1.5 font-normal text-gray-500">vs last week</span>
            </div>
        </div>
        <div class="mt-4">
            <VueApexCharts :options="chartOptions" :series="[{ data: stat?.series }]" />
        </div>
    </div>
</template>