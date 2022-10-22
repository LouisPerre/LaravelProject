<template>
    <h1>Ajouter un article</h1>

    <form @submit.prevent="sendForm()">
        <div>
            <label for="title" class="block font-medium text-sm text-gray-700">Title</label>
            <input type="text" name="title" v-model="form.title" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        </div>

        <div>
            <label for="album" class="block font-medium text-sm text-gray-700">Album</label>
            <select name="album" v-model="form.album" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option v-for="album in albums" :key="album.id" :value="album.id"><img :src="'/storage/' + album.cover" :alt="album.name">{{ album.name }}</option>
            </select>
        </div>

        <div v-if="form.album === null">
            <label for="cover">Cover</label>
            <input
                name="cover"
                type="file"
                class="mt-1 block w-full block w-full text-sm text-slate-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-violet-50 file:text-violet-700
                      hover:file:bg-violet-100"
                required
                ref="cover"
                accept="image/*"
                @change="handleCover"
            />
        </div>

        <div>
            <label for="file">File</label>
            <input
                name="file"
                type="file"
                class="mt-1 block w-full block w-full text-sm text-slate-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-violet-50 file:text-violet-700
                      hover:file:bg-violet-100"
                required
                ref="file"
                accept=".mp3,audio/*"
                @change="handleFile"
            />
        </div>

        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Ajoute ta mere</button>
        </div>


    </form>
</template>

<script>
import {ref} from "vue";

const cover = ref(null)
const file = ref(null)

export default {
    name: "CreateArticle",
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                album: null,
                cover: null,
                file: null
            })
        }
    },
    props: [
        'albums'
    ],
    methods: {
        sendForm() {
            this.form.post(route('music.store'))
        },
        handleCover(event) {
            this.form.cover = event.target.files[0]
        },
        handleFile(event) {
            this.form.file = event.target.files[0]
        }
    }
}
</script>

<style scoped>

</style>
