<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // condizioni di validazioni salvate in alto poichè le richiameremo più volte, non ha senso ripetere lo stesso array in più punti diversi
    private $postValidationArray = [
        'title' => 'required|max:255',
        'content' => 'required'
    ];

    // funzione per generare slug che non abbiano doppioni, la chiamiamo su store e su update
    private function generateSlug($data) {

        $slug = Str::slug($data["title"], '-'); // titolo-articolo-3

        // chiamata query al db, settiamo con la variabile existingslug il primo slug del db che non ammetterà duplicati
        $existingPost = Post::where('slug', $slug)->first();
        // dd($existingPost);

        // se lo slug esiste già, dobbiamo rigenerarlo. possiamo aggiungere allo slug doppione un trattino e un numero. per farlo usiamo un ciclo while che si interrompe quando la condizione di uscita viene soddisfatta
        $slugBase = $slug;
        $counter = 1;

        while($existingPost) {
            $slug = $slugBase . "-" . $counter;

            // istruzioni per terminare il ciclo, riverifico con una nuova query l'esistenza dello slug. Se esiste il ciclo riparte con l'incremento, se non esiste la condizione del while è falsa ed esco dal ciclo.
            $existingPost = Post::where('slug', $slug)->first(); 
            // incremento 
            $counter++;
        }

    // salvo lo slug
        return $slug;
    }

    public function index()
    {
        $posts = Post::all();
        // compact costruisce un array associativo con chiave la stringa che mettiamo e valore quelli messi nel db, restituisce una collection del Model Post
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.posts.create');
        // devo passare alla vista anche le categorie (nel foreach select), quindi devo importare il model category (in alto), fare la query al db con ::all e passarla con un compact

        $categories = Category::all();

        return view('admin.posts.create', compact('categories'));


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();


        // validazione personalizzata, invece di inserire l'array associativo con i requisiti, uso la variabile che li contiene
        $request->validate($this->postValidationArray);

        // creazione e salvataggio nuova istanza di classe Post
        $newPost = new Post();

        // genero lo slug con la mia private function
        $slug = $this->generateSlug($data);
        // $newPost->title = $data["title"];
        // $newPost->content = $data["content"];

        // salvo lo slug nei miei data
        $data['slug'] = $slug;
        $newPost->fill($data); 

        $newPost->save();

        return redirect()->route('admin.posts.show', $newPost->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();
        
        // validazione
        $request->validate($this->postValidationArray);

        // se il titolo dopo la modifica è diverso dal precedente, devo ricomporre lo slug
        if($post->title != $data["title"]) {
            $slug = $this->generateSlug($data);

            $data["slug"] = $slug;
        }

        $post->update($data);

        return redirect()->route('admin.posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        // faccio un redirect all'index, with ci serve per aggiungere dati alla sessione (flash). passo una chiave 'deleted' e come valore il dato che voglio fare viaggiare, nel caso voglia fare un alert con il titolo dell'articolo che voglio eliminare
        return redirect()
        ->route('admin.posts.index')
        ->with('deleted', $post->title);
    }
}
