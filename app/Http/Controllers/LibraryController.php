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

        $book = new Book();
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->published_year = $request->published_year;
        $book->save();

        return redirect('/books');
    }

    public function showBook($id)
    {
        //$book = Book::find($id);
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
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->published_year = $request->published_year;
        $book->save();

        return redirect('/books');
    }

    public function destroyBook($id)
    {
        $book = Book::find($id);
        $book->delete();

        return redirect('/books');
    }

    // Authors
    public function indexAuthors()
    {
        //$authors = Author::all();
        $authors = Author::with('books')->get();
        return view('library.authors', compact('authors'));
    }

    public function createAuthor()
    {
        return view('library.author_form');
    }

    public function storeAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $author = new Author();
        $author->name = $request->name;
        $author->save();

        return redirect('/authors');
    }

    public function showAuthor($id)
    {
        $author = Author::find($id);
        return view('library.author_form', compact('author'));
    }

    public function updateAuthor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $author = Author::find($id);
        $author->name = $request->name;
        $author->save();

        return redirect('/authors');
    }

    public function destroyAuthor($id)
    {
        $author = Author::find($id);
        $author->delete();

        return redirect('/authors');
    }

    // Borrowers
    public function indexBorrowers()
    {
        $borrowers = Borrower::all();
        return view('library.borrowers', compact('borrowers'));
    }

    public function createBorrower()
    {
        return view('library.borrower_form');
    }

    public function storeBorrower(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $borrower = new Borrower();
        $borrower->name = $request->name;
        $borrower->save();

        return redirect('/borrowers');
    }

    public function showBorrower($id)
    {
        //$borrower = Borrower::find($id);
        $borrower = Borrower::with('profile')->find($id);
        return view('library.borrower_form', compact('borrower'));
    }

    public function updateBorrower(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $borrower = Borrower::find($id);
        $borrower->name = $request->name;
        $borrower->save();

        return redirect('/borrowers');
    }

    public function destroyBorrower($id)
    {
        $borrower = Borrower::find($id);
        $borrower->delete();

        return redirect('/borrowers');
    }
    
}
