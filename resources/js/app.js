import './bootstrap'

import app from "./App.vue"
import { createApp } from 'vue'

// Vuetify
import "vuetify/styles"
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from "vuetify"
import * as components from "vuetify/components"
import * as directives from "vuetify/directives"

const vuetify = createVuetify({
    components,
    directives,
});

import router from "./router.js"

createApp(app)
    .use(vuetify)
    .use(router)
    .mount("#app")
