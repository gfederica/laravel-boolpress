@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- con with messo in deleted posso flashare i dati passati nella sessione, li mostro alla vista col metodo session.
        Se esiste la sessione deleted, mostro un messaggio di cancellazione--}}
        @if (session('deleted'))
            <div class="alert alert-warning">Hai eliminato l'articolo: {{session('deleted')}}</div>
        @endif
        <h1 class="my-4">BoolPress - Archivio</h1>
        <a class="btn btn-outline-primary mb-4" href="{{ route('admin.posts.create') }}">Nuovo articolo</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Titolo</th>
                    <th>Slug</th>
                    <th colspan="3">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->slug }}</td>
                        <td class="table-text"><a class="btn btn-info" href="{{ route('admin.posts.show', $item->id) }}">SHOW</a></td>
                        <td class="table-text-warn"><a class="btn btn-warning" href="{{ route('admin.posts.edit', $item->id) }}">EDIT</a></td>
                        <td class="table-text">
                            <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST" onSubmit="return confirm('Sei sicuro di voler eliminare questo articolo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">DELETE</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection