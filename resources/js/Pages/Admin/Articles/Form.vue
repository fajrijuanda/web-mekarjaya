<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import { computed } from 'vue';

const props = defineProps({
    article: Object, // Akan null jika membuat baru
});

const isEditing = computed(() => !!props.article);

const form = useForm({
    title: props.article?.title || '',
    content: props.article?.content || '',
    status: props.article?.status || 'draft',
});

// Konfigurasi TipTap Editor
const editor = useEditor({
    content: form.content,
    extensions: [
        StarterKit,
    ],
    onUpdate: ({ editor }) => {
        form.content = editor.getJSON(); // Simpan konten sebagai JSON
    },
});

const submit = () => {
    if (isEditing.value) {
        form.put(route('articles.update', props.article.id));
    } else {
        form.post(route('articles.store'));
    }
};
</script>

<template>
    <AppLayout :title="isEditing ? 'Edit Artikel' : 'Buat Artikel Baru'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isEditing ? 'Edit Artikel' : 'Buat Artikel Baru' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" class="bg-white shadow-xl sm:rounded-lg p-6">
                    <div class="mb-6">
                        <label for="title" class="block font-medium text-sm text-gray-700">Judul</label>
                        <input type="text" id="title" v-model="form.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-lg" placeholder="Judul artikel Anda...">
                    </div>

                    <div class="mb-6">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Konten</label>
                        <div v-if="editor" class="border border-gray-300 rounded-md p-2">
                            <div class="flex items-center space-x-2 border-b pb-2 mb-2">
                                <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{'is-active': editor.isActive('bold')}" class="px-2 py-1 rounded">Bold</button>
                                <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{'is-active': editor.isActive('italic')}" class="px-2 py-1 rounded">Italic</button>
                                <button type="button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{'is-active': editor.isActive('heading', { level: 2 })}" class="px-2 py-1 rounded">H2</button>
                                </div>
                            <EditorContent :editor="editor" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                         <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select id="status" v-model="form.status" class="mt-1 block border-gray-300 rounded-md shadow-sm">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-blue-600 text-white rounded-md font-semibold">
                            {{ isEditing ? 'Perbarui Artikel' : 'Simpan Artikel' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style>
/* Styling dasar untuk editor TipTap */
.ProseMirror {
    min-height: 250px;
    padding: 0.5rem;
}
.ProseMirror:focus {
    outline: none;
}
.is-active {
    background-color: #e0e0e0;
}
</style>