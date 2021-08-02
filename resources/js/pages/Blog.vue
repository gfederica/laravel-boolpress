<template>
    <div class="container" v-if="posts.length > 0">
        <h2>Articoli</h2>
        <div class="row">
            <!-- oppure v-for post,index e key=index -->
            <Card 
            v-for="post in posts"
            :key="post.id"
            :item="post"
            />
            </div>
            <div class="text-center mb-4">

                <!-- lo mostro se la pagina corrente è maggiore di 1, per tornare indietro -->
                <button 
                v-show="current_page > 1"
                class="btn btn-info mr-2"
                @click="getPosts(current_page - 1)"
                >
                Prev
                </button>

                <!-- se la pagina è quella corrente, il button ha un colore, altrimenti un altro stile, ne mostro tanti quante sono le pagine -->
                <button 
                class="btn mr-2"
                :class="(n == current_page) ? 'btn-primary' : 'btn-info'"
                v-for="n in last_page"
                :key="n"
                @click="getPosts(n)"  
                >
                {{ n }}
                </button>

                <!-- se la pagina attiva non è l'ultima, al click vado avanti di pag. -->
                <button 
                v-show="current_page < last_page"
                class="btn btn-info"
                @click="getPosts(current_page + 1)"
                >
                Next
                </button>
            </div>
    </div>
    <Loader v-else />
</template>

<script>
import Card from '../components/Card';
import Loader from '../components/Loader';

export default {
    name: 'Blog',
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
       Card,
       Loader
    },
    // chiamata axios con created
    //posso spostarla in un method e poi richiamare la funzione nel created
    created: function() {
       this.getPosts();
    }
}
</script>

<style>

</style>