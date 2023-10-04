<script setup>

</script>

<template>
    <v-app>
        <v-app-bar>
            <v-container class="d-flex align-center">
                <v-app-bar-title style="max-width: 150px">Amo Spa</v-app-bar-title>

                <v-tabs
                    centered
                    color="grey-darken-2"
                >
                    <v-tab
                        text="Выбор сделки"
                        :to="{name: 'index'}"
                    ></v-tab>

                    <v-tab
                        text="История"
                        :to="{name: 'logs'}"
                    ></v-tab>
                </v-tabs>
            </v-container>
        </v-app-bar>

        <v-main style="height: calc(100% - 80px)">
            <v-container style="height: 100%">
                <router-view/>
            </v-container>
        </v-main>

        <v-footer absolute>
            <v-container>
                <span>&copy; {{ new Date().getFullYear() }}</span>
            </v-container>
        </v-footer>
    </v-app>
</template>

<style scoped>

</style>
