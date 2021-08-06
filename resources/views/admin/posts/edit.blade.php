@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Modifica: <span class="text-secondary">{{ $post->title }}</span></h1>
        
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Inserisci il titolo dell'articolo" name="title" value="{{ old('title', $post->title) }}">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="content">Testo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="6" name="content" placeholder="Inserisci il testo dell'articolo">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

             {{-- upload immagine, for, name e id stesso nome, non possiamo settare l'old ma se esiste un immagine prima della modifica, possiamo visualizzarne un'anteprima --}}
             <div class="form-group">
                <label for="cover">Immagine Articolo:</label>
                {{-- visualizzazione anteprima --}}
                @if ($post->cover)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$post->cover)}}" alt="{{$post->title}}" style="width: 200px">
                </div>
                @endif
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
                        {{-- devo sdoppiare la struttura perchè i tag inviati con l'edit sono nella collection del model post e non più semplici array: 
                         Mantengo la struttura dell'old per gestire errori di validazione, mentre per recuperare il tag precedente devo usare contains.
                         Uso la struttura base di laravel per la gestione degli errori con @if($errors->any()) che restituisce un booleano --}}
                        @if ($errors->any())
                            <input class="form-check-input" name="tags[]" type="checkbox" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
                            >
                        @else
                            <input class="form-check-input" name="tags[]" type="checkbox" id="tag-{{ $tag->id }}" value="{{ $tag->id }}"
                            {{-- metodo contains. Si usa per determinare se l'istanza di un modello è in una collection. 
                            Se il model del post che sto modificando contiene l'id di un determinato tag, metto il checked a quel value --}}
                            {{ $post->tags->contains($tag->id) ? 'checked' : '' }}
                            > 
                        @endif
                        
                        <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                    </div>     
                @endforeach 
                @error('tags')
                    <div>
                        <small class="text-danger">{{ $message }}</small> 
                    </div>
                @enderror   
            </div>    
            <button type="submit" class="btn btn-primary">Salva</button>
            <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">Elenco Post</a>
        </form>
    </div>
@endsection