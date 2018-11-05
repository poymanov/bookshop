<?php

namespace App\Http\Controllers\Admin;

use App\Services\BooksService;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    private $service;

    /**
     * BooksController constructor.
     */
    public function __construct()
    {
        $this->service = new BooksService();
        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $books = Book::paginate(12);

        return view('admin.book.index', compact('books'));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Book $book)
    {
        return view('admin.book.show', compact('book'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $authors = Author::all();

        return view('admin.book.create', compact('authors'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->service::VALIDATION_RULES);
        $data = $this->service->processImageUpload($request, $data);
        $book = Book::create($data);

        return redirect(route('admin.books.show', $book));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Book $book)
    {
        $authors = Author::all();

        return view('admin.book.edit', compact('book', 'authors'));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Book $book)
    {
        $data = request()->validate($this->service::VALIDATION_RULES);
        $data = $this->service->processImageUpload($request, $data);

        $book->update($data);

        return redirect(route('admin.books.show', $book));
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect(route('admin.books.index'));
    }
}
