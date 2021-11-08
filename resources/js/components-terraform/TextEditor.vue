<template>
    <div v-if="editor" class="text-editor-wrapper">
        <bubble-menu class="bubble-menu" :tippy-options="{ duration: 100 }" :editor="editor" v-if="editor">
            <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
                Bold
            </button>
            <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
                Italic
            </button>
            <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
                Strike
            </button>
        </bubble-menu>

        <floating-menu class="floating-menu" :tippy-options="{ duration: 100 }" :editor="editor" v-if="editor">
            <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
                H1
            </button>
            <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
                H2
            </button>
            <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
                Bullet List
            </button>
        </floating-menu>

        <button @click="showModal = true;">
            <img src="/editor-icons/image-line.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run()">
            <img src="/editor-icons/table-2.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleBold().run()" :class="{ 'is-active': editor.isActive('bold') }">
            <img src="/editor-icons/bold.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleItalic().run()" :class="{ 'is-active': editor.isActive('italic') }">
            <img src="/editor-icons/italic.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleStrike().run()" :class="{ 'is-active': editor.isActive('strike') }">
            <img src="/editor-icons/strikethrough.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().setParagraph().run()" :class="{ 'is-active': editor.isActive('paragraph') }">
            <img src="/editor-icons/paragraph.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 1 }) }">
            <img src="/editor-icons/h-1.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }">
            <img src="/editor-icons/h-2.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }">
            <img src="/editor-icons/h-3.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 4 }) }">
            <img src="/editor-icons/h-4.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 5 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 5 }) }">
            <img src="/editor-icons/h-5.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" :class="{ 'is-active': editor.isActive('heading', { level: 6 }) }">
            <img src="/editor-icons/h-6.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'is-active': editor.isActive('bulletList') }">
            <img src="/editor-icons/list-check.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'is-active': editor.isActive('orderedList') }">
            <img src="/editor-icons/list-ordered.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleCodeBlock().run()" :class="{ 'is-active': editor.isActive('codeBlock') }">
            <img src="/editor-icons/code-view.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'is-active': editor.isActive('blockquote') }">
            <img src="/editor-icons/double-quotes.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().setHorizontalRule().run()">
            <img src="/editor-icons/line-height.svg" class="w-5">
        </button>
        <button @click="setLink" :class="{ 'is-active': editor.isActive('link') }">
            <img src="/editor-icons/link.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().undo().run()">
            <img src="/editor-icons/undo.svg" class="w-5">
        </button>
        <button @click="editor.chain().focus().redo().run()">
            <img src="/editor-icons/redo.svg" class="w-5">
        </button>
    </div>
    <editor-content :editor="editor"/>
    <TerraModal v-model="showModal" @confirm="" @cancel="showModal = false;">
        <template v-slot:title>Dodaj zdjęcie</template>
        <Dropzone @uploaded="addFiles"></Dropzone>
    </TerraModal>
</template>

<script>
import {
    Editor, EditorContent, useEditor, BubbleMenu,
    FloatingMenu,
} from '@tiptap/vue-3'
import Link from '@tiptap/extension-link'
import StarterKit from '@tiptap/starter-kit'
import Image from '@tiptap/extension-image'
import {onMounted, ref} from "vue";
import TerraModal from "./TerraModal";
import Dropzone from "./Dropzone";

const {watch} = require("vue");

export default {
    name: "TextEditor",
    components: {
        Dropzone,
        TerraModal,
        EditorContent,
        BubbleMenu,
        FloatingMenu,
        Image
    },
    props: {
        val: {
            type: String,
            default: '',
        },
        files: {
            type: Array,
            default: [],
        },
    },
    setup(props, {emit}) {
        const showModal = ref(false);
        const editor = useEditor({
            content: props.val,
            extensions: [
                StarterKit,
                Link.configure({
                    openOnClick: false,
                }),
                Image.configure({
                    HTMLAttributes: {
                        class: 'prose-image',
                    },
                })
            ],
            editorProps: {
                attributes: {
                    class: 'form-control',
                },
            },
            onUpdate: () => {
                emit('update:val', editor.value.getHTML())
            },
        })

        const showAddImage = () => {

        }

        const addFiles = (files) => {
            console.log(editor.value.chain());
            console.log(files);
            console.log(editor.value.chain().focus().setImage());
            editor.value.chain().focus().setImage({src: files[0]}).run()

            emit('update:files', files);
        }

        onMounted(() => {
            console.log(editor);

        });


        return {
            editor,
            showModal,
            showAddImage,
            addFiles
        }
    }
}
</script>

<style lang="scss">
/* Basic editor styles */
.ProseMirror {
    > * + * {
        margin-top: 0.75em;
    }

    ul,
    ol {
        padding: 0 1rem;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        line-height: 1.1;
    }

    code {
        background-color: rgba(#616161, 0.1);
        color: #616161;
    }

    pre {
        background: #0D0D0D;
        color: #FFF;
        font-family: 'JetBrainsMono', monospace;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;

        code {
            color: inherit;
            padding: 0;
            background: none;
            font-size: 0.8rem;
        }
    }

    img {
        max-width: 100%;
        height: auto;
    }

    blockquote {
        padding-left: 1rem;
        border-left: 2px solid rgba(#0D0D0D, 0.1);
    }

    hr {
        border: none;
        border-top: 2px solid rgba(#0D0D0D, 0.1);
        margin: 2rem 0;
    }
}
.bubble-menu {
    display: flex;
    background-color: #0D0D0D;
    padding: 0.2rem;
    border-radius: 0.5rem;

    button {
        border: none;
        background: none;
        color: #FFF;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0 0.2rem !important;
        opacity: 0.6;


        &:hover,
        &.is-active {
            opacity: 1;
        }
    }
}

.floating-menu {
    display: flex;
    background-color: #0D0D0D10;
    padding: 0.2rem;
    border-radius: 0.5rem;

    button {
        border: none;
        background: none;
        font-size: 0.85rem;
        font-weight: 500;
        padding: 0 0.2rem !important;
        opacity: 0.6;

        &:hover,
        &.is-active {
            opacity: 1;
        }
    }
}
</style>
