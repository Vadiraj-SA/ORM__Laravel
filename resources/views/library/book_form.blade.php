<!-- resources/views/library/book_form.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ isset($book) ? 'Edit' : 'Add' }} Book</h1>
            <form action="{{ isset($book) ? url('/books/' . $book->id) : url('/books') }}" method="POST">
                @csrf
                @if (isset($book))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $book->title ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="author_id">Author</label>
                    <select class="form-control" id="author_id" name="author_id">
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" {{ (isset($book) && $book->author_id == $author->id) ? 'selected' : '' }}>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="published_year">Published Year</label>
                    <input type="number" class="form-control" id="published_year" name="published_year" value="{{ $book->published_year ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($book) ? 'Update' : 'Add' }} Book</button>
            </form>
        </div>
    </div>
@endsection
