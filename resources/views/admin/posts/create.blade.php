@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Nuovo articolo</h1>
        {{-- enctype dice al form che c'è l'inserimento e invio di file --}}
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="title">Titolo</label>
                {{-- old conserva l'input precedente in caso di errori legati ad altri campi --}}
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Titolo" name="title" value="{{ old('title') }}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Testo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="6" name="content" placeholder="Inserisci il testo dell'articolo">{{ old('content') }}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
             {{-- upload immagine, for, name e id stesso nome, non abbiamo possibilità di settare l'old --}}
             <div class="form-group">
                <label for="cover"></label>
                <input type="file" class="form-control-file @error('cover') is-invalid @enderror" name="cover" id="cover">
                @error('cover')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- fine upload --}}
            {{-- select per scegliere la categoria al momento della creazione --}}
            <div class="form-group">
                {{-- label e select id hanno lo stesso nome così gestisco il focus sul click --}}
                <label for="category_id">Categorie</label>
                {{-- gestisco l'errore in caso di forzatura del value, i parametri sono sul validationarray di postcontroller --}}
                <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                    <option value="">Seleziona la Categoria</option>
                    @foreach ($categories as $category)
                    {{-- nel value metto il dato che passo al form, l'id della cat. --}}
                        <option value="{{$category->id}}"
                            {{-- ternario che mi gestisce il selected: se c'è un old mette quello, altrimenti il campo è vuoto --}}
                            {{ ($category->id == old('category_id')) ? 'selected' : '' }}
                            >{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group mb-5">
                <h5>Tags</h5>
                @foreach ($tags as $tag)
                    <div class="form-check form-check-inline">
                        {{-- uso l'id del tag perchè devo indicare all'html quale valore ciclare, in alternativa posso scrivere '$loop->iteration' --}}
                        {{-- per gli altri input il name era il nome della colonna di riferimento, per questo input mettiamo tags[]  perchè deve raccogliere tutte le selezioni, formando un array --}}
                        <input class="form-check-input" name="tags[]" type="checkbox" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                        {{-- se c'è un errore di validazione, devo conservare il valore precedentemente scelto, essendo un array di valori uso un ternario con la funzione in_array, che verifica la presenza di un dato in un array. sintassi in_array(argomento da cercare, argomento array dove cercare). nel secondo parametro abbiamo messo old(o tags se c'è una selezione, o un array vuoto se non c'è) --}}
                        {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>     
                @endforeach 
                @error('tags')
                    <div>
                        <small class="text-danger">{{ $message }}</small> 
                    </div>
                @enderror   
            </div>    
            <button type="submit" class="btn btn-primary">Crea</button>
            <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">Torna all'elenco</a>
        </form>
    </div>
@endsection 