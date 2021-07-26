// importo vue
window.Vue = require('vue');

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
