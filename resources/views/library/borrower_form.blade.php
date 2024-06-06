<!-- resources/views/library/borrower_form.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ isset($borrower) ? 'Edit' : 'Add' }} Borrower</h1>
            <form action="{{ isset($borrower) ? url('/borrowers/' . $borrower->id) : url('/borrowers') }}" method="POST">
                @csrf
                @if (isset($borrower))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $borrower->name ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($borrower) ? 'Update' : 'Add' }} Borrower</button>
            </form>
        </div>
    </div>
@endsection
