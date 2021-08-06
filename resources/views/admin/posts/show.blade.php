@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1>{{ $post->title }}
            {{-- se esiste una categoria associata, la visualizzo. navigo e stampo le proprietà della tabella categories navigando la collection categories, è come se facessi una inner join fra le tabelle post e categories. laravel lo fa in automatico perchè ho definito la relazione sui model --}}
            {{-- se voglio visualizzare gli articoli con quella categoria, mi serve un categorycontroller che mi gestisca le route e importarle su web.php --}}
            @if ($post->category)    
            {{-- rotta parametrica, devo specificare l'id della categoria del post attivo     --}}
                <a href="{{ route('admin.categories.show', $post->category->id) }}" class="badge badge-info">{{ $post->category->name }}</a>
            @else
                <span class="badge badge-secondary">Nessuna Categoria</span>     
            @endif
        </h1>
        <small>{{ $post->slug }}</small>
        <div class="mt-3">
            <a class="btn btn-warning" href="{{ route('admin.posts.edit', $post->id) }}">Modifica</a>
            <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">Torna all'elenco</a>
        </div>
        {{-- cover + articolo --}}
        {{-- asset genera url partendo dalla cartella public --}}
        <div class="row mt-4">
            <div class="col-md-6">
                @if ($post->cover)
                    <img class="img-fluid" src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}">
                @else 
                    <img class="img-fluid" src="{{ asset('images/placeholder.png') }}" alt="{{ $post->title }}">
                @endif
               
            </div>
            <div class="col-md-6">
                {{ $post->content }}
            </div>
        </div>
        {{-- gestisco la visualizzazione dei tags. Se ci sono li visualizzo con un foreach --}}
        @if (count($post->tags) > 0)
            <div class="mt-5 h4">
                <h5>Tag correlati:</h5>
                @foreach ($post->tags as $tag)
                    <span class="badge badge-pill badge-success">{{ $tag->name }}</span>    
                @endforeach
            </div>
        @else
            <h5 class="mt-3">Nessun tag</h5>    
        @endif
    </div>
@endsection