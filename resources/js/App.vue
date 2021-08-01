<template>

  <div class="container">
    <Header/> 

    <main>
      <h2>Articoli</h2>
      <div class="row">
        <!-- oppure v-for post,index e key=index -->
        <Card 
          v-for="post in posts"
          :key="post.id"
          :item="post"
        />
        </div>
    </main>

  </div>

</template>

<script>
// import axios from 'axios'; // chiamata axios locale
import Header from './components/Header';
import Card from './components/Card';
// import UnderConstruction from './components/UnderConstruction';
export default {
    name: 'App',
    // inizializzo nei data l'array coi post vuoto, che popolerò dinamicamente nella chiamata axios
    data: function() {
      return {
        posts: []
      }
    },
    components: {
      //  UnderConstruction,
       Header,
       Card
    },
    // chiamata axios con created
    created: function() {
      axios
      .get('http://127.0.0.1:8000/api/posts')
      .then(
        res => {
          // console.log(res.data);
          this.posts = res.data;
        }
      )
      .catch(
        err => {
          console.log(err);
        }
      )
    }
}
</script>

<style lang="scss">
  @import '../sass/front.scss';
</style>