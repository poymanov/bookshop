<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $books = Book::paginate(12);
        return view('admin.book.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('admin.book.show', compact('book'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('admin.book.create', compact('authors'));
    }

    public function store()
    {
        $book = Book::create(request()->validate([
            'title' => 'required',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required',
            'year' => 'required',
            'pages_count' => 'required',
            'price' => 'required'
        ]));

        return redirect(route('admin.books.show', $book));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('admin.book.edit', compact('book', 'authors'));
    }

    public function update(Book $book)
    {
        $book->update(request()->validate([
            'title' => 'required',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required',
            'year' => 'required',
            'pages_count' => 'required',
            'price' => 'required'
        ]));

        return redirect(route('admin.books.show', $book));
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect(route('admin.books.index'));
    }

}
