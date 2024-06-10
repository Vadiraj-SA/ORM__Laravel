<!-- resources/views/library/borrowers.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List of Borrowers</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Borrowed Books</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($borrowers as $borrower)
                    <tr>
                        <td>{{ $borrower->name }}</td>
                        <td>
                            @foreach ($borrower->books as $book)
                                {{ $book->title }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="/borrowers/{{ $borrower->id }}/edit" class="btn btn-warning">Edit</a>
                            <form action="/borrowers/{{ $borrower->id }}" method="POST" style="display:inline-block;">
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
@endsection
