<template>
  <div class="col-4 my-3 d-flex">
        <div class="card w-100">
            <div class="card-body">
                <h4 class="card-title">{{ item.title }}</h4>
                <p>{{ truncateText(item.content) }}</p>
                <a href="#" class="card-link">Leggi</a>
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