// importo vue
window.Vue = require('vue');

// chiamata axios globale, lo avvio su front.js e lo richiamo nei vari componenti
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// importo componente App
import App from './App.vue';


// creo nuova istanza vue, collegata al div di guest > home.blade.php con id 'root'
const app = new Vue(
    {
        el: '#root',
        // utilizza app, funzione hook
        render: h => h(App)
    }
);
