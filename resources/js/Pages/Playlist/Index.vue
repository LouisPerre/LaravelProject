<template>
    <h1>Les playlists :</h1>
    <a :href="route('playlist.create')">Ajouter une nouvelle playlist</a>

    <div v-for="playlist in playlists" :key="playlist.id" class="card">
        <h2>{{ playlist.name }}</h2>
    </div>
</template>

<script>
export default {
    name: "Index",
    props: [
        'playlists'
    ]
}
</script>

<style scoped>

</style>
