<template>
  <UnderConstruction
    title='Work in progress'
    subtitle='Sito in costruzione - Ritorna più tardi!'/>
</template>

<script>
// import axios from 'axios'; // chiamata axios locale
import UnderConstruction from './components/UnderConstruction';
export default {
    name: 'App',
    components: {
       UnderConstruction
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
</style>