<!-- resources/views/library/authors.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Authors</h1>
            <a href="/authors/create" class="btn btn-primary mb-3">Add Author</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Books</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $author)
                        <tr>
                            <td>{{ $author->name }}</td>
                            <td>
                                <ul>
                                    @foreach ($author->books as $book)
                                        <li>{{ $book->title }} ({{ $book->published_year }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="/authors/{{ $author->id }}/edit" class="btn btn-warning">Edit</a>
                                <form action="/authors/{{ $author->id }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

