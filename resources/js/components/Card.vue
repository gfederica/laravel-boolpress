<template>
  <div class="col-4 my-3 d-flex">
        <div class="card w-100">
          <img  class="card-img-top" :src="item.cover" alt="">
            <div class="card-body">
                <h4 class="card-title">{{ item.title }}</h4>
                <p>{{ truncateText(item.content) }}</p>
                <!-- insieme all'attributo parametrico su router.js, definisco il dato dinamico nei params -->
                <router-link :to="{ name: 'single-post', params: { slug: item.slug } }">Leggi</router-link>
                
            </div>
        </div>       
    </div>
</template>

<script>
export default {
    name: 'Card',
    props: { 'item' : Object },
    // metodo nella card per accorciare l'anteprima del testo dell'articolo
    methods: {
      truncateText: function(string, charsNumber = 100) {
        if(string.length > charsNumber) {
          return string.substr(0, charsNumber) + '...';
        } else {
          return string;
        }
      }
    },
}
</script>

<style>
</style>