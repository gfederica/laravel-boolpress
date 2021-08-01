<template>

  <div class="container">
    <Header/> 
    <UnderConstruction
      title='Work in progress'
      subtitle='Sito in costruzione - Ritorna più tardi!'/>
  </div>

</template>

<script>
// import axios from 'axios'; // chiamata axios locale
import Header from './components/Header';
import UnderConstruction from './components/UnderConstruction';
export default {
    name: 'App',
    components: {
       UnderConstruction,
       Header
    },
    //chiamata axios con created
    // created: function() {
    //   axios
    //   .get('http://127.0.0.1:8000/api/posts')
    //   .then(
    //     res=>{
    //       console.log(res.data);
    //     }
    //   )
    //   .catch(
    //     err => {
    //       console.log(err);
    //     }
    //   )
    // }
}
</script>

<style lang="scss">
  @import '../sass/front.scss';
</style>