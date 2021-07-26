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
            <button type="submit" class="btn btn-primary">Crea</button>
            <a class="btn btn-secondary ml-2" href="{{ route('admin.posts.index') }}">Torna all'elenco</a>
        </form>
    </div>
@endsection 