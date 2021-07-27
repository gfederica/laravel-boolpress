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
        <div class="mt-4">{{ $post->content }}</div>
    </div>
@endsection