<!-- resources/views/library/book_form.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($borrower) ? 'Edit Borrower' : 'Add Borrower' }}</h1>
    <form method="POST" action="{{ isset($borrower) ? route('borrowers.update', $borrower->id) : route('borrowers.store') }}">
        @csrf
        @if(isset($borrower))
            @method('PUT')
        @endif
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $borrower->name ?? old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="{{ $borrower->profile->address ?? old('address') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $borrower->profile->phone ?? old('phone') }}" required>
        </div>

        <div class="form-group">
            <label for="book_id">Select Borrowed Book</label>
            <select class="form-control" id="book_id" name="book_id">
                <option value="">Select a book</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ (isset($borrower) && $borrower->books->contains($book->id)) ? 'selected' : '' }}>
                        {{ $book->title }} ({{ $book->is_available ? 'Available' : 'Unavailable' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="borrowed_date">Borrowed Date</label>
            <input type="date" class="form-control" id="borrowed_date" name="borrowed_date" value="{{ old('borrowed_date') }}">
        </div>

        <div class="form-group">
            <label for="returned_date">Returned Date</label>
            <input type="date" class="form-control" id="returned_date" name="returned_date" value="{{ old('returned_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($borrower) ? 'Update Borrower' : 'Add Borrower' }}</button>
    </form>
</div>
@endsection
