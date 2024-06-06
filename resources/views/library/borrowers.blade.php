<!-- resources/views/library/borrowers.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Borrowers</h1>
            <a href="/borrowers/create" class="btn btn-primary mb-3">Add Borrower</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($borrowers as $borrower)
                        <tr>
                            <td>{{ $borrower->name }}</td>
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
    </div>
@endsection
