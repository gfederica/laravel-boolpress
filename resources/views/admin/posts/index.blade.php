@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Articoli in DB:</h1>
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
                        <td>EDIT</td>
                        <td>DELETE</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection