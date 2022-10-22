<template>
    <h1>{{ album.name }}</h1>
    <img :src="'/storage/' + album.cover" :alt="album.name">
    <p>
        {{ album.date_of_creation }}
    </p>
    <p v-for="music in album.musics">
        music.name
    </p>
    <button @click="deleteAlbum(album)">Supprimer cet article</button>
</template>

<script>
export default {
    name: "Show",
    props: [
        'album'
    ],
    methods: {
        deleteAlbum(album) {
            this.$inertia.delete(route('album.delete', album))
        }
    }
}
</script>

<style scoped>

</style>
