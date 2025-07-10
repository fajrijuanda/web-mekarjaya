<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { onMounted, onBeforeUnmount, ref, watch } from 'vue';

// Tiptap imports
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Image from '@tiptap/extension-image'; // Untuk menambahkan dukungan gambar
import Link from '@tiptap/extension-link';   // Untuk menambahkan dukungan link

const props = defineProps({
    article: Object, // Prop ini akan ada jika kita mengedit artikel
});

const form = useForm({
    title: props.article ? props.article.title : '',
    slug: props.article ? props.article.slug : '',
    content: props.article ? props.article.content : '<p>Start writing...</p>', // Konten HTML awal
    status: props.article ? props.article.status : 'draft',
    is_editing: !!props.article, // Tambahkan prop ini untuk menandai mode edit
});

// Generate slug from title
watch(() => form.title, (newTitle) => {
    if (!form.is_editing) { // Only auto-generate if not in edit mode
        form.slug = newTitle.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-')       // collapse whitespace and replace by -
            .replace(/-+/g, '-');       // collapse dashes
    }
});

const editor = useEditor({
    content: form.content, // Load existing content
    extensions: [
        StarterKit,
        Image.configure({
            inline: true, // Allow images to be inline with text
            HTMLAttributes: {
                class: 'inline-block align-middle my-2', // Basic Tailwind classes for images
            },
        }),
        Link.configure({
            openOnClick: false, // Prevents opening link when clicking in editor
            autolink: true,
            linkOnPaste: true,
        }),
        // Tambahkan ekstensi Tiptap lain sesuai kebutuhan (misal: Table, Iframe, dll.)
    ],
    onUpdate: ({ editor }) => {
        // Update form.content saat editor berubah
        form.content = editor.getHTML();
    },
});

const addImage = () => {
    const url = window.prompt('URL');

    if (url) {
        editor.value.chain().focus().setImage({ src: url }).run();
    }
};


// Hancurkan editor saat komponen di-unmount untuk mencegah memory leaks
onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});

const submit = async () => {
    // Pastikan konten terbaru dari editor sudah di-sync ke form.content
    // (Ini sudah terjadi secara otomatis via onUpdate)
    if (form.is_editing) {
        form.put(route('admin.articles.update', props.article.id), {
            onSuccess: () => console.log('Article updated!'),
            onError: (errors) => console.error('Error updating article:', errors),
        });
    } else {
        form.post(route('admin.articles.store'), {
            onSuccess: () => console.log('Article created!'),
            onError: (errors) => console.error('Error creating article:', errors),
        });
    }
};
</script>

<style>
/* Some basic Tiptap editor styling for ProseMirror content */
/* This will make the rendered HTML inside the editor look good */
.tiptap p {
    margin: 0;
}

.tiptap:focus {
    outline: none;
}

.tiptap .is-active {
    background-color: #e2e8f0;
    /* bg-gray-200 */
}

/* Add custom styling for ProseMirror, e.g., for different blocks */
.prose img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    /* rounded-lg */
    display: block;
    /* Ensures images are block-level */
    margin-top: 1em;
    margin-bottom: 1em;
}

/* For image resizing/handles, you'd need additional Tiptap extensions and styling */
</style>

<template>
    <AppLayout :title="form.is_editing ? 'Edit Article' : 'Create Article'">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ form.is_editing ? 'Edit Article' : 'Create Article' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="title" value="Title" />
                            <TextInput id="title" v-model="form.title" type="text" class="mt-1 block w-full" required
                                autofocus autocomplete="title" />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="slug" value="Slug" />
                            <TextInput id="slug" v-model="form.slug" type="text" class="mt-1 block w-full" required />
                            <InputError class="mt-2" :message="form.errors.slug" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="content" value="Content" />
                            <div v-if="editor" class="border border-gray-300 rounded-md">
                                <div class="p-2 space-x-1 border-b">
                                    <button type="button" @click="editor.chain().focus().toggleBold().run()"
                                        :class="{ 'is-active': editor.isActive('bold') }"
                                        class="px-2 py-1 rounded hover:bg-gray-200">
                                        B
                                    </button>
                                    <button type="button" @click="editor.chain().focus().toggleItalic().run()"
                                        :class="{ 'is-active': editor.isActive('italic') }"
                                        class="px-2 py-1 rounded hover:bg-gray-200">
                                        I
                                    </button>
                                    <button type="button" @click="editor.chain().focus().toggleBulletList().run()"
                                        :class="{ 'is-active': editor.isActive('bulletList') }"
                                        class="px-2 py-1 rounded hover:bg-gray-200">
                                        UL
                                    </button>
                                    <button type="button" @click="editor.chain().focus().toggleOrderedList().run()"
                                        :class="{ 'is-active': editor.isActive('orderedList') }"
                                        class="px-2 py-1 rounded hover:bg-gray-200">
                                        OL
                                    </button>
                                    <button type="button" @click="editor.chain().focus().setHardBreak().run()"
                                        class="px-2 py-1 rounded hover:bg-gray-200">
                                        BR
                                    </button>
                                    <button type="button" @click="editor.chain().focus().undo().run()"
                                        :disabled="!editor.can().undo()" class="px-2 py-1 rounded hover:bg-gray-200">
                                        undo
                                    </button>
                                    <button type="button" @click="editor.chain().focus().redo().run()"
                                        :disabled="!editor.can().redo()" class="px-2 py-1 rounded hover:bg-gray-200">
                                        redo
                                    </button>
                                    <button type="button" @click="addImage" class="px-2 py-1 rounded hover:bg-gray-200">
                                        add image
                                    </button>
                                </div>
                                <EditorContent :editor="editor" class="p-4 prose max-w-none" />
                            </div>
                            <InputError class="mt-2" :message="form.errors.content" />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="status" value="Status" />
                            <select v-model="form.status" id="status"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                {{ form.is_editing ? 'Update Article' : 'Create Article' }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
