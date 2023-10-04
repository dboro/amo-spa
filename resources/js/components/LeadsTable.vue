<script setup>
import {onMounted, ref} from "vue";
import {getLeads} from "../service.js";
import {toDate} from "../helpers.js";

const items = ref([])
const loading = ref(false)

onMounted(async () => {
    loading.value = true
    items.value = await getLeads()
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
                        Id
                    </th>

                    <th class="text-left">
                        Название
                    </th>

                    <th class="text-left">
                        Дата создания
                    </th>

                    <th class="text-center">
                        Есть контакт
                    </th>

                    <th class="text-right">
                        Действия
                    </th>
                </tr>
                </thead>

                <tbody>
                <tr
                    v-for="item in items"
                    :key="item.id"
                >
                    <td>{{ item.id }}</td>

                    <td>{{ item.name }}</td>

                    <td>{{ toDate(item.created_at) }}</td>

                    <td class="text-center">
                        <v-chip
                            v-if="item.contacts"
                            class="ma-2"
                            color="success"
                        >
                            Да
                        </v-chip>
                        <v-chip
                            v-else
                            class="ma-2"
                        >
                            Нет
                        </v-chip>
                    </td>

                    <td class="text-right">
                        <v-btn
                            color="info"
                            size="small"
                            :disabled="typeof item.contacts !== 'undefined'"
                            :to="{name: 'add-contact', params: {id: item.id}}"
                        >
                            Привязать контакт
                        </v-btn>
                    </td>
                </tr>
                </tbody>
            </v-table>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
