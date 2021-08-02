<template>
  <section class="my-5">

  </section>
</template>

<script>
export default {
    name: 'SinglePost',
    created: function() {
        console.log(this.$route.params.slug)
    }
}
</script>

<style>

</style>