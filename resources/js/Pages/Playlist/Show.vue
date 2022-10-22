<template>
    <h1>{{ playlist.name }}</h1>
    <img :src="'/storage/' + playlist.cover" :alt="playlist.name">
    <p>
        {{ playlist.date_of_creation }}
    </p>
    <p>{{ playlist.description }}</p>
    <div>
        <p v-if="playlist.visibility">La playlist est privee</p>
        <p v-else>La playlist est publique</p>
    </div>

    <p v-for="music in playlist.musics">
        music.name
    </p>
    <button @click="deletePlaylist(playlist)">Supprimer cette playlist</button>
</template>

<script>
export default {
    name: "Show",
    props: [
        'playlist'
    ],
    methods: {
        deletePlaylist(playlist) {
            this.$inertia.delete(route('playlist.delete', playlist))
        }
    }
}
</script>

<style scoped>

</style>
