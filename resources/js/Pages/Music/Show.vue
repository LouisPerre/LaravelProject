<template>
    <h1>{{ music.name }}</h1>
    <img v-if="music.cover" :src="'/storage/' + music.cover" :alt="music.name">
    <p>
        {{ music.date_of_creation }}
    </p>
    <div>
        <img :src="'/storage/' + music.album.cover" :alt="music.album.name">
        {{ music.album.name }}
        {{ music.user.pseudo }}
    </div>
    <button @click="deleteArticle(music)">Supprimer cet article</button>
</template>

<script>
export default {
    name: "Show",
    props: [
        'music'
    ]
}
</script>

<style scoped>

</style>
