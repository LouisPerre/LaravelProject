<template>
    <h1>Les album :</h1>
    <a :href="route('album.create')">Ajouter un nouvel album</a>

    <div v-for="album in albums" :key="album.id" class="card">
        <h2>{{ album.name }}</h2>
        <button @click="deleteAlbum(album)">Supprimer cet album</button>
    </div>
</template>

<script>
export default {
    name: "Index",
    props: [
        'albums'
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
