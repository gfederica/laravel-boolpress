import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

// importo i componenti che uso nelle rotte
import Home from './pages/Home';
import Blog from './pages/Blog';
import Contatti from './pages/Contatti';

const router = new VueRouter({
    mode: 'history',  //man mano che mi sposto tra le pagine, usa solo il path che definisco nelle rotte. Di default aggiunge '#'
    routes : [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/blog',
            name: 'blog',
            component: Blog 
         },
         {
            path: '/contatti',
            name: 'contatti',
            component: Contatti 
         }
    ] // short for `routes: routes`
  });

  export default router;
