<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    settings: Object,
});

const form = useForm({
    village_history: props.settings.village_history || '',
    village_vision: props.settings.village_vision || '',
    village_mission: props.settings.village_mission || '',
});

const submit = () => {
    form.put(route('admin.profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            // Bisa tambahkan notifikasi sukses
        },
    });
};
</script>

<template>
    <AppLayout title="Edit Profil Desa">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Profil Desa
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="history" class="block font-medium text-sm text-gray-700">Sejarah Desa</label>
                            <textarea id="history" v-model="form.village_history" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="vision" class="block font-medium text-sm text-gray-700">Visi</label>
                            <textarea id="vision" v-model="form.village_vision" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="mission" class="block font-medium text-sm text-gray-700">Misi</label>
                            <textarea id="mission" v-model="form.village_mission" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        </div>

                        <button type="submit" :disabled="form.processing" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>