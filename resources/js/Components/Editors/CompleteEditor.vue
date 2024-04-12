<template>
    <div v-if="editor" class="flex flex-wrap gap-1 p-2 border-b-2 mb-2">
        <div class="w-full text-center font-bold">OUTILS</div>
        <button @click="editor.chain().focus().toggleBold().run()"
                :disabled="!editor.can().chain().focus().toggleBold().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('bold') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            bold
        </button>
        <button @click="editor.chain().focus().toggleItalic().run()"
                :disabled="!editor.can().chain().focus().toggleItalic().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('italic') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            italic
        </button>
        <button @click="editor.chain().focus().toggleStrike().run()"
                :disabled="!editor.can().chain().focus().toggleStrike().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('strike') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            strike
        </button>
        <button @click="editor.chain().focus().toggleCode().run()"
                :disabled="!editor.can().chain().focus().toggleCode().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('code') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            code
        </button>
        <button @click="editor.chain().focus().unsetAllMarks().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            clear marks
        </button>
        <button @click="editor.chain().focus().clearNodes().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            clear nodes
        </button>
        <button @click="editor.chain().focus().setParagraph().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('paragraph') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            paragraph
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 1 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h1
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 2 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h2
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 3 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h3
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 4 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 4 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h4
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 5 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 5 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h5
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 6 }).run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('heading', { level: 6 }) }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            h6
        </button>
        <button @click="editor.chain().focus().toggleBulletList().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('bulletList') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            bullet list
        </button>
        <button @click="editor.chain().focus().toggleOrderedList().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('orderedList') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            ordered list
        </button>
        <button @click="editor.chain().focus().toggleCodeBlock().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('codeBlock') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            code block
        </button>
        <button @click="editor.chain().focus().toggleBlockquote().run()"
                :class="{ 'bg-gray-700 text-white': editor.isActive('blockquote') }"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            blockquote
        </button>
        <button @click="editor.chain().focus().setHorizontalRule().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            horizontal rule
        </button>
        <button @click="editor.chain().focus().setHardBreak().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            hard break
        </button>
        <button @click="addImage"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            add image
        </button>
        <button @click="editor.chain().focus().undo().run()" :disabled="!editor.can().chain().focus().undo().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            undo
        </button>
        <button @click="editor.chain().focus().redo().run()" :disabled="!editor.can().chain().focus().redo().run()"
                class="border-2 border-gray-300 p-1 text-sm rounded-md hover:bg-gray-300 text-gray-500">
            redo
        </button>
    </div>
    <div class="w-full text-center font-bold">CONTENU</div>
    <div class="border-b-2 p-2">
    <editor-content :editor="editor"/>
    </div>

</template>

<script setup>
import {defineProps, defineEmits, onBeforeUnmount} from 'vue'
import {useEditor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import {Document} from '@tiptap/extension-document';
import Dropcursor from '@tiptap/extension-dropcursor'
import Image from '@tiptap/extension-image'
import {watch} from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: 'Ici votre contenu'
    },
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
    content: props.modelValue,
    onUpdate: ({editor}) => {
        emit('update:modelValue', editor.getHTML())
    },
    extensions: [
        StarterKit,
        Document,
        Image,
        Dropcursor,
    ],
})

const addImage = () => {
    const url = window.prompt('URL')
    if (url) {
        editor.value.chain().focus().setImage({ src: url }).run()
    }
}

// Watch of modelValue
watch(() => props.modelValue, (value) => {
    if (value !== editor.value.getHTML()) {
        editor.value.commands.setContent(value)
    }
})

onBeforeUnmount(() => {
    editor.value.destroy()
})

</script>
