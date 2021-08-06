<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\Tag;
use App\Category;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // condizioni di validazioni salvate in alto poichè le richiameremo più volte, non ha senso ripetere lo stesso array in più punti diversi
    //aggiungo la regola di validazione per category_id con sintassi exists:nometabella,nomecolonna in modo che non ci siano errori se viene inserito un input non presente in db
    private $postValidationArray = [
        'title' => 'required|max:255',
        'content' => 'required',
        //validazione per controllare se l'id della categoria esiste nell'array delle categorie
        'category_id' => 'nullable|exists:categories,id',
        // validazione per controllare se i valori selezionati esistono nell'array dei tag, a diff. di categories dobbiamo controllare più valori in una volta
        'tags' => 'exists:tags,id',
        // esiste anche 'image' ma in locale dà errore
        'cover' => 'nullable|mimes:jpg,jpeg,png,svg|max:500'
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
        $posts = Post::paginate(4);
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
        $tags = Tag::all();

        return view('admin.posts.create', compact('categories', 'tags'));


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

        // salvo lo slug nei miei data e lo salvo

        //aggiungiamo cover nei fillable, e facciamo l'upload solo se c'è un immagine (solo se c'è la chiave cover nei data di quel singolo post)
        //Dobbiamo salvare non l'oggetto immagine che viene caricato, ma la singola immagine. Importiamo nello use la classe Storage e lo usiamo per caricare il path dell'immagine con la funzione Storage::put() dove tra parentesi indichiamo la sotto-cartella dove salvare l'immagine e come secondo parametro l'oggetto istanza della classe input uploaded file (con un dd si vede l'oggetto Illuminate)
        // Storage restituisce il percorso relativo del file, adesso dobbiamo salvarlo in una nuova variabile e dentro il db (con $data["cover"] = $img_path sostituisco quello che avevo prima in data cover - ovvero l'oggetto -  e sovrascrivo il path)
        if(array_key_exists('cover', $data)) {
            $img_path = Storage::put('post_covers', $data["cover"]);
            // sovrascrivo l'oggetto di classe uploadedFile con il nome del file restituito dalla put
            $data["cover"] = $img_path;

            // comando per upload/cancellazione in un disco diverso da quello di default (disk + public/local/s3)
            // $img_path = Storage::disk('public', $data["cover"]);

        }

        $data['slug'] = $slug;
        $newPost->fill($data); 
        //possiamo aggiungere manualmente il salvataggio del category_id oppure aggiungerlo in fillable, così da essere recuperato in automatico
     
        
        $newPost->save();

        // dobbiamo salvare i tag scelti nello store di ogni articolo, quindi nella tabella ponte post_tag. usiamo il metodo attach()
        //il metodo if gestisce la possibilità di non aver selezionato alcun tag al momento della creazione. Se esiste una chiave all'interno dell array dei tag, faccio l'attach
        //funzione array_key_exists(parametro chiave da cercare, parametro array dove cercare)
        if(array_key_exists('tags', $data)) {
            // va bene anche il metodo sync, ma ha più senso attach perché non ci sono tags inizialmente
            $newPost->tags()->attach($data["tags"]);
        }

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
        // qui non ho bisogno di importare category perchè viene specificata la relazione sui modelli
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
        // anche qui devo passare il model category
        $categories = Category::all();
        $tags = Tag::all();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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

        // gestisco l'update della cover. Se c'è già un'immagine al momento dell'upload, cancello quella precedente con Storage::delete($post->cover)
        if(array_key_exists('cover', $data)) {
            if($post->cover) {
                Storage::delete($post->cover);
            }
            $data["cover"] = Storage::put('post_covers', $data["cover"]);
        } 

        // categoria viene importata dal fillable del model post
        $post->update($data);


        //come per lo store, aggiorno i tag dei post (se ce ne sono). 
        // uso sync per sincronizzare i nuovi tags, e nell'else uso detach (se il post conteneva tags ma dopo la modifica non ne ha più)
        if(array_key_exists('tags', $data)) {
            $post->tags()->sync($data["tags"]);
        } else {
            // $post->tags->sync([]);
            $post->tags()->detach();
        }

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
        // gestisco la cancellazione dell'immagine, se presente. POtrei lasciare solo post->delete, ma in questo modo cancello anche il file da public, così non appesantisco il sito di file inutili
        if($post->cover) {
            Storage::delete($post->cover);
        }


        $post->delete();
        //non mi serve la cancellazione della riga nella tabella ponte, perchè è gestito da onDelete Cascade. In alternativa uso:
        // $post->tags()->detach();
 
        // faccio un redirect all'index, with ci serve per aggiungere dati alla sessione (flash). passo una chiave 'deleted' e come valore il dato che voglio fare viaggiare, nel caso voglia fare un alert con il titolo dell'articolo che voglio eliminare
        return redirect()
        ->route('admin.posts.index')
        ->with('deleted', $post->title);
    }
}
