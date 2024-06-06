<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Books routes
Route::get('/books', [LibraryController::class, 'indexBooks'])->name('books.index');
Route::get('/books/create', [LibraryController::class, 'createBook'])->name('books.create');
Route::post('/books', [LibraryController::class, 'storeBook'])->name('books.store');
Route::get('/books/{id}', [LibraryController::class, 'showBook'])->name('books.show');
Route::put('/books/{id}', [LibraryController::class, 'updateBook'])->name('books.update');
Route::delete('/books/{id}', [LibraryController::class, 'destroyBook'])->name('books.destroy');

// Authors routes
Route::get('/authors', [LibraryController::class, 'indexAuthors'])->name('authors.index');
Route::get('/authors/create', [LibraryController::class, 'createAuthor'])->name('authors.create');
Route::post('/authors', [LibraryController::class, 'storeAuthor'])->name('authors.store');
Route::get('/authors/{id}', [LibraryController::class, 'showAuthor'])->name('authors.show');
Route::put('/authors/{id}', [LibraryController::class, 'updateAuthor'])->name('authors.update');
Route::delete('/authors/{id}', [LibraryController::class, 'destroyAuthor'])->name('authors.destroy');

// Borrowers routes
Route::get('/borrowers', [LibraryController::class, 'indexBorrowers'])->name('borrowers.index');
Route::get('/borrowers/create', [LibraryController::class, 'createBorrower'])->name('borrowers.create');
Route::post('/borrowers', [LibraryController::class, 'storeBorrower'])->name('borrowers.store');
Route::get('/borrowers/{id}', [LibraryController::class, 'showBorrower'])->name('borrowers.show');
Route::put('/borrowers/{id}', [LibraryController::class, 'updateBorrower'])->name('borrowers.update');
Route::delete('/borrowers/{id}', [LibraryController::class, 'destroyBorrower'])->name('borrowers.destroy');

Route::get('/books/{id}/edit', [LibraryController::class, 'showBook'])->name('books.edit');
