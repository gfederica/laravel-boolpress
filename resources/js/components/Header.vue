<template>
    <header>
      <nav>
          <ul>
              <li>
                 <!-- <a href="#" class="active">Home</a> -->

                    <!-- use router-link component for navigation. -->
                    <!-- specify the link by passing the `to` prop. -->
                    <!-- `<router-link>` will be rendered as an `<a>` tag by default -->
                  <router-link :to="{ name: 'home' }">Home</router-link>
              </li>
              <li>
                  <router-link :to="{ name: 'blog' }">Blog</router-link>
              </li>
              <li>
                  <router-link :to="{ name: 'contatti' }">Contatti</router-link>
              </li>
          </ul>
      </nav>
  </header>
</template>

<script>
export default {
    name: 'Header'
}
</script>

<style lang='scss' scoped>
    header {
            text-align:center;
            margin-top: 30px;
            li {
                display: inline-block;
                a {    
                    display: inline-block;
                    padding: 5px 10px;
                    color: black;
                    font-size: 18px;
                    text-decoration: none;
                    &.active,
                    &:hover {
                        background-color: lightgreen;
                        font-weight: bolder;
                    }
                }
            }
        }
</style>