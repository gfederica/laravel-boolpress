<template>

  <div class="container">
    <Header/> 

    <main>
        <!-- component matched by the route will render here -->
        <!-- un po' come il controller di laravel -->
        <router-view></router-view>
    </main>

    <Footer/>

  </div>

</template>

<script>
// import axios from 'axios'; // chiamata axios locale
import Header from './components/Header';
// import Card from './components/Card';
import Footer from './components/Footer';
// import UnderConstruction from './components/UnderConstruction';
export default {
    name: 'App',
    // inizializzo nei data l'array coi post vuoto, che popolerò dinamicamente nella chiamata axios
    data: function() {
      return {
        posts: [],
        current_page: 1,
        last_page: 1
      }
    },
    methods: {
       getPosts: function(page = 1) {
        axios
        // pagina con valore di default 1, gestisco la navigazione sui buttons
        .get(`http://127.0.0.1:8000/api/posts?page=${page}`)
        .then(
          res => {
            this.posts = res.data.data;
            this.current_page = res.data.current_page;
            this.last_page = res.data.last_page;
          }
        )
        .catch(
          err => {
            console.log(err);
          }
        );
      }
    },
    components: {
      //  UnderConstruction,
       Header,
      //  Card,
       Footer
    },
    // chiamata axios con created
    //posso spostarla in un method e poi richiamare la funzione nel created
    created: function() {
       this.getPosts();
    }
}
</script>

<style lang="scss">
  @import '../sass/front.scss';
</style>