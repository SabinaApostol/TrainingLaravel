import { createApp } from 'vue'
import App from './Pages/App.vue'
import router from './index'

createApp(App).use(router).mount('#app')

require('./bootstrap');
