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
            ->first(); // EAGER LOADING (in Blade LAZY LOADING)

        return response()->json($post);
    }
}
