<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();
        //stessa logica dei controller web. Recupero i miei post e restituisco direttamente la collection dentro json
        // $posts = Post::paginate(3);

        
        // $result = [
        //     'success' = true,
        //     'posts' = $posts
        // ]

        // return response()->json($result);


        return response()->json($posts);
    }
}
