<!-- resources/views/library/author_form.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ isset($author) ? 'Edit' : 'Add' }} Author</h1>
            <form action="{{ isset($author) ? url('/authors/' . $author->id) : url('/authors') }}" method="POST">
                @csrf
                @if (isset($author))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $author->name ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($author) ? 'Update' : 'Add' }} Author</button>
            </form>
        </div>
    </div>
@endsection
