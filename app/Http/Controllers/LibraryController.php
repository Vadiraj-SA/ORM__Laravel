<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Borrower;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // Books
    public function indexBooks()
    {
        $books = Book::with('author')->get();
        return view('library.books', compact('books'));
    }

    public function createBook()
    {
        $authors = Author::all();
        return view('library.book_form', compact('authors'));
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'published_year' => 'required|integer',
        ]);

        Book::create($request->all());
        return redirect('/books');
    }

    public function showBook($id)
    {
        $book = Book::with('author')->find($id);
        $authors = Author::all();
        return view('library.book_form', compact('book', 'authors'));
    }

    public function updateBook(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'author_id' => 'required',
            'published_year' => 'required|integer',
        ]);

        $book = Book::find($id);
        $book->update($request->all());
        return redirect('/books');
    }

    public function destroyBook($id)
    {
        Book::find($id)->delete();
        return redirect('/books');
    }

    // Authors
    public function indexAuthors()
    {
        $authors = Author::with('books')->get();
        return view('library.authors', compact('authors'));
    }

    public function createAuthor()
    {
        return view('library.author_form');
    }

    public function storeAuthor(Request $request)
    {
        $request->validate(['name' => 'required']);
        Author::create($request->all());
        return redirect('/authors');
    }

    public function showAuthor($id)
    {
        $author = Author::find($id);
        return view('library.author_form', compact('author'));
    }

    public function updateAuthor(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $author = Author::find($id);
        $author->update($request->all());
        return redirect('/authors');
    }

    public function destroyAuthor($id)
    {
        Author::find($id)->delete();
        return redirect('/authors');
    }

    // Borrowers
    public function indexBorrowers()
    {
        $borrowers = Borrower::with('books')->get();
        return view('library.borrowers', compact('borrowers'));
    }

    public function createBorrower()
{
    $books = Book::where('is_available', true)->get();
    return view('library.borrower_form', compact('books'));
}


//     public function createBorrower()
// {
//     $books = Book::where('is_available', true)->get();
//     return view('library.borrower_form', compact('books'));
// }

    // public function createBorrower()
    // {
    //     $books = Book::all();
    //     return view('library.borrower_form', compact('books'));
    // }

    public function storeBorrower(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'book_id' => 'nullable|exists:books,id',
            'borrowed_date' => 'nullable|date',
            'returned_date' => 'nullable|date',
        ]);

        $borrower = Borrower::create(['name' => $request->input('name')]);

        $borrower->profile()->create([
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
        ]);

        if ($request->has('book_id') && $request->input('book_id')) {
            $book_id = $request->input('book_id');
            $borrower->books()->attach($book_id, [
                'borrowed_at' => $request->input('borrowed_date'),
                'returned_at' => $request->input('returned_date'),
            ]);

            $book = Book::find($book_id);
            $book->is_available = !$request->input('borrowed_date');
            $book->save();
        }

        return redirect('/borrowers');
    }

    public function showBorrower($id)
{
    $borrower = Borrower::with(['profile', 'books'])->find($id);
    $books = Book::where('is_available', true)->get(); // Fetch only available books
    return view('library.borrower_form', compact('borrower', 'books'));
}

//     public function showBorrower($id)
// {
//     $borrower = Borrower::with(['profile', 'books'])->find($id);
//     $books = Book::where('is_available', true)->get(); // Fetch only available books
//     return view('library.borrower_form', compact('borrower', 'books'));
// }
    // public function showBorrower($id)
    // {
    //     $borrower = Borrower::with(['profile', 'books'])->find($id);
    //     $books = Book::all(); // Fetch all books to be displayed in the dropdown
    //     return view('library.borrower_form', compact('borrower', 'books'));
    // }

    public function updateBorrower(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'book_id' => 'nullable|exists:books,id',
            'borrowed_date' => 'nullable|date',
            'returned_date' => 'nullable|date',
        ]);

        $borrower = Borrower::findOrFail($id);
        $borrower->update(['name' => $request->input('name')]);

        if ($borrower->profile) {
            $borrower->profile->update([
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ]);
        } else {
            $borrower->profile()->create([
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
            ]);
        }

        $borrower->books()->detach();
        if ($request->has('book_id') && $request->input('book_id')) {
            $book_id = $request->input('book_id');
            $borrower->books()->attach($book_id, [
                'borrowed_at' => $request->input('borrowed_date'),
                'returned_at' => $request->input('returned_date'),
            ]);

            $book = Book::find($book_id);
            $book->is_available = !$request->input('borrowed_date');
            $book->save();
        }

        return redirect('/borrowers');
    }

    public function destroyBorrower($id)
    {
        Borrower::findOrFail($id)->delete();
        return redirect('/borrowers');
    }

    // Borrow Books
    public function createBorrow()
    {
        $borrowers = Borrower::all();
        $books = Book::where('is_available', true)->get();
        return view('library.borrow_form', compact('borrowers', 'books'));
    }

    public function storeBorrow(Request $request)
    {
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'book_id' => 'required|exists:books,id'
        ]);

        $book = Book::find($request->book_id);
        if ($book->is_available) {
            $borrower = Borrower::find($request->borrower_id);
            $borrower->books()->attach($book, ['borrowed_at' => now()]);

            // Update the book availability
            $book->update(['is_available' => false]);

            return redirect('/borrowers')->with('success', 'Book borrowed successfully!');
        } else {
            return redirect()->back()->with('error', 'Book is not available.');
        }
    }

    // Return Books
    public function returnBook(Request $request, $id)
    {
        $request->validate([
            'borrower_id' => 'required|exists:borrowers,id',
            'book_id' => 'required|exists:books,id'
        ]);

        $borrower = Borrower::find($request->borrower_id);
        $borrower->books()->updateExistingPivot($request->book_id, ['returned_at' => now()]);

        // Update the book availability
        $book = Book::find($request->book_id);
        $book->update(['is_available' => true]);

        return redirect('/borrowers')->with('success', 'Book returned successfully!');
    }
}
