<template>
<!-- mostro la sezione se il post esiste e se loading è false: la chiamata axios è andata a buon fine -->
  <section class="my-5" v-if="!loading && post">
      <h1>{{ post.title }}</h1>

        <div class="post-info my-3">
            <h4 v-if="post.category">
                <span class="badge badge-primary">{{ post.category.name }}</span>
            </h4>
            <!-- mostro i tag se ce ne sono -->
            <div class="h5" v-if="post.tags.length > 0">
                <span 
                    v-for="tag in post.tags"
                    :key="`tag-${tag.id}`"
                    class="badge badge-pills badge-info mr-2">
                {{ tag.name }}
                </span>
            </div>
        </div>

      <p class="my-4">{{ post.content }}</p>

      <router-link class="btn btn-primary" :to="{ name: 'blog' }">Torna al Blog</router-link>
  </section>
  <Loader v-else />
</template>

<script>
import Loader from '../components/Loader';
export default {
    name: 'SinglePost',
    components: {
        Loader
    },
    created: function() {
        // richiamo il metodo della chiamata axios al created
        this.getPost(this.$route.params.slug)
    },
    // collection post inizialmente vuota
    data: function() {
        return {
            post: null,
            loading: true
        }
    },
     methods: {
        //  chiamata axios singolo post, come parametro mi serve lo slug perchè lo passo nella query get
        getPost: function(slug) {
            axios
                .get(`http://127.0.0.1:8000/api/posts/${slug}`)
                .then(
                    res => {
                        this.post = res.data;
                        // se importo dei dati, il loading diventa false, disattivo la vista del loader nel v-if dell'articolo
                        this.loading = false;
                    }
                )
                .catch(
                    err => {
                        console.log(err);
                    }
                );
        }
    }
}
</script>

<style>

</style>