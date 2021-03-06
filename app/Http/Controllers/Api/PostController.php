<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        //stessa logica dei controller web. Recupero i miei post e restituisco direttamente la collection dentro json

        // $posts = Post::all();
        $posts = Post::paginate(6);

        
        // gestisco il recupero della cover con il metodo each, che si applica sulle collection (codice alternativo più in basso), per visualizzare la cover sulla pagina Blog
        
        // $posts->each(function ($post) {
        //     if($post->cover) {
        //         $post->cover = url('storage/'.$post->cover);
        //     } else {
        //         $post->cover = url('images/placeholder.png');
        //     }
        // });


        foreach($posts as $post) {
            if($post->cover) {
                $post->cover = url('storage/'.$post->cover);
                } else {
                $post->cover = url('images/placeholder.png');
                }
        }


        // $result = [
        //     'success' = true,
        //     'posts' = $posts
        // ]

        // return response()->json($result);


        return response()->json($posts);
    }
    // recupero il singolo post(faccio un filtro where per recuperare il post con lo slug selezionato, un with per unire alla tabella le info su categorie e tags, e first per restituire solo il primo risultato che matcha i criteri di ricerca), richiamo il controller dentro api.php
    public function show($slug) {

        $post = Post::where('slug', $slug)
            ->with(['category', 'tags'])
            ->first(); // EAGER LOADING (in Blade LAZY LOADING, fa una query ogni volta che nel blade cerco una proprietà della tabella, serve a velocizzare le query.) Per gli api, laravel usa l'eager loading, ovvero devo chiedere subito i dati che mi servono, in questo caso le relazioni nella tabella posts (categorie e tags, coi nomi dei metodi usati nel model) usando i metodo with.

            // in alternativa, posso aggiungere al Model Post.php: 
            // protected $with = ['category', 'tags'] farà l'eager loading globale, che varrà per ogni query

            // gestisco il recupero della cover se esiste, sulla pagina singlepost.
            // per salvarla uso il metodo url che funziona come l'asset laravel
            if(!empty($post)) {
                if($post->cover) {
                    $post->cover = url('storage/'.$post->cover);
                } else {
                    $post->cover = url('images/placeholder.png');
                }
            }

        return response()->json($post);
    }
}
