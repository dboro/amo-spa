<script setup>
import ContactForm from "../components/ContactForm.vue";
import {useRoute, useRouter} from "vue-router";

const router = useRouter()
const route = useRoute()

</script>

<template>
    <ContactForm @submit="router.push({name: 'index'})" :id="route.params.id"></ContactForm>
</template>

<style scoped>

</style>
