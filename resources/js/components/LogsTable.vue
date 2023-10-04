<script setup>
import {onMounted, ref} from "vue";
import {getLogs} from "../service.js";
import {toDate} from "../helpers.js";

const items = ref([])
const loading = ref(false)

onMounted(async () => {
    loading.value = true
    items.value = await getLogs()
    loading.value = false
})
</script>

<template>
    <v-card :loading="loading">
        <v-card-text>
            <v-table>
                <thead>
                <tr>
                     <th class="text-left">
                         Дата и время
                    </th>

                    <th class="text-left">
                        Действие
                    </th>

                    <th class="text-center">
                        Результат
                    </th>
                </tr>
                </thead>

                <tbody>
                <tr
                    v-for="item in items"
                    :key="item.id"
                >
                    <td>{{ toDate(item.created_at) }}</td>

                    <td>{{ item.action }}</td>

                    <td class="text-center">
                        <v-icon v-if="item.result" color="success">mdi-check</v-icon>
                        <v-icon v-else color="error">mdi-close</v-icon>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
