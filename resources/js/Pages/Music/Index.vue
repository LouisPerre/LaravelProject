<template>
    <h1>Les musics :</h1>
    <a :href="route('music.create')">Ajouter une nouvelle musique</a>

    <div v-for="music in musics" :key="music.id" class="card">
        <h2>{{ music.name }}</h2>
        <button @click="deleteMusic(music)">Supprimer cette musique</button>
    </div>
</template>

<script>
export default {
    name: "MusicIndex",
    props: [
        'musics'
    ],
    methods: {
        deleteMusic(music) {
            this.$inertia.delete(route('music.delete', music))
        }
    }
}
</script>

<style scoped>

</style>
