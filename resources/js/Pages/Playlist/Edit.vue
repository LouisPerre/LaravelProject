<template>
    <h1>Ajouter une playlist</h1>

    <form @submit.prevent="sendForm()">
        <div>
            <label for="title" class="block font-medium text-sm text-gray-700">Nom</label>
            <input type="text" name="title" v-model="form.name" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        </div>

        <div>
            <label for="desc" class="block font-medium text-sm text-gray-700">Description</label>
            <textarea name="desc" v-model="form.description" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
        </div>

        <div>
            <label for="cover">Cover</label>
            <p>Current cover</p>
            <img :src="'/storage/' + playlist.cover" :alt="playlist.name">
            <input
                name="cover"
                type="file"
                class="mt-1 block w-full block w-full text-sm text-slate-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-violet-50 file:text-violet-700
                      hover:file:bg-violet-100"
                ref="cover"
                accept="image/*"
                @change="handleCover"
            />
        </div>

        <div>
            <label for="visibility" class="block font-medium text-sm text-gray-700">Cette playlist est prive ?</label>
            <input type="checkbox" name="visibility" v-model="form.visibility" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
        </div>

        <div>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">Ajoute ta mere</button>
        </div>


    </form>
</template>

<script>
export default {
    name: "Create",
    data() {
        return {
            form: this.$inertia.form({
                _method: 'put',
                name: this.playlist.name,
                description: this.playlist.description,
                cover: this.playlist.cover,
                visibility: this.playlist.visibility
            })
        }
    },
    props: [
        'playlist'
    ],
    methods: {
        sendForm() {
            this.form.post(route('playlist.update', this.playlist.id))
        },
        handleCover(event) {
            this. form.cover= event.target.files[0]
        },

    }
}
</script>

<style scoped>

</style>
