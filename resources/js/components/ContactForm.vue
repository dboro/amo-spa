<script setup>

import {onMounted, ref} from "vue";
import {addContact} from "../service.js";
import {useRoute} from "vue-router";

onMounted(() => {
    model.value.leadId = props.id
})

const emits = defineEmits([
    'submit'
])

const props = defineProps({
    id: {
        required: true
    }
})

const model = ref({})

const valid = ref(true)

const loading = ref(false)
const submit = async () => {
    try {
        loading.value = true
        await addContact(model.value)
        emits('submit')
    }
    finally {
        loading.value = false
    }
}
</script>

<template>
    <v-card>
        <v-card-title>Привязка контакта</v-card-title>

        <v-card-text>
            <v-form @submit.prevent="submit" v-model="valid">
                <v-text-field
                    v-model="model.name"
                    :rules="[(val) => val ? true : 'Имя обязательно для заполнения']"
                    variant="outlined"
                    density="comfortable"
                    label="Имя*"
                    class="mb-3"
                ></v-text-field>

                <v-text-field
                    v-model="model.phone"
                    :rules="[(val) => val ? true : 'Телефон обязательн для заполнения']"
                    variant="outlined"
                    density="comfortable"
                    label="Телефон*"
                    class="mb-3"
                ></v-text-field>

                <v-textarea
                    v-model="model.comment"
                    :rules="[(val) => val ? true : 'Комментарий обязательн для заполнения']"
                    variant="outlined"
                    density="comfortable"
                    label="Комментарий*"
                    class="mb-3"
                ></v-textarea>

                <div class="d-flex">
                    <v-btn
                        :disabled="!valid"
                        :loading="loading"
                        color="success"
                        type="submit"
                    >
                        Привязать
                    </v-btn>

                    <v-spacer/>

                    <v-btn
                        :to="{name: 'index'}"
                    >
                        Отмена
                    </v-btn>
                </div>
            </v-form>
        </v-card-text>
    </v-card>
</template>

<style scoped>

</style>
