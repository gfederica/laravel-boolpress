import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// importo i componenti che uso nelle rotte
import Home from './pages/Home';

const router = new VueRouter({
    mode: 'history',  //man mano che mi sposto tra le pagine, usa solo il path che definisco nelle rotte. Di default aggiunge '#'
    routes : [
        {
            path: '/',
            component: Home
        }
    ] // short for `routes: routes`
  });

  export default router;
