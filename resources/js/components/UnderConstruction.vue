<template>
<div class="container d-flex justify-content-center align-items-center">
    <div class="text-center">
        <h1>{{ title }}</h1>
        <h2>{{ subtitle }}</h2>
    </div>
  </div>
</template>

<script>
export default {
    name: 'UnderConstruction',
    props: [ 'title', 'subtitle' ]
}
</script>

<style lang="scss" scoped>
    .container {
        height: 100vh;
         
            h1 {
            color: darkmagenta;
    }
    }
   
</style>