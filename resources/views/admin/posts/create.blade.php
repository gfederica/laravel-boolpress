@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Nuovo articolo</h1>
        <form action="{{ route('admin.posts.store') }}" method="POST">
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
            {{-- select per scegliere la categoria al momento della creazione --}}
            <div class="form-group">
                {{-- label e select id hanno lo stesso nome così gestisco il focus sul click --}}
                <label for="category_id">Categorie</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="">Seleziona la Categoria</option>
                    @foreach ($categories as $category)
                    {{-- nel value metto il dato che passo al form, l'id della cat. --}}
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Crea</button>
            <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">Torna all'elenco</a>
        </form>
    </div>
@endsection 