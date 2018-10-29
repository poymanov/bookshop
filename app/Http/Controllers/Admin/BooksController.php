<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Book;
use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    /**
     * BooksController constructor.
     */
    public function __construct()
    {
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
    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required',
            'year' => 'required',
            'pages_count' => 'required',
            'price' => 'required',
            'cover' => 'nullable|image'
        ]);

        if (request()->exists('cover')) {
            $coverPath = request()->file('cover')->store('covers', 'public');
            $data['image'] = $coverPath;

            if (! app()->environment('testing')) {
                $this->resizeImage($coverPath);
            }
        }

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
    public function update(Book $book)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'author_id' => 'required|exists:authors,id',
            'isbn' => 'required',
            'year' => 'required',
            'pages_count' => 'required',
            'price' => 'required',
            'cover' => 'nullable|image'
        ]);

        if (request()->exists('cover')) {
            $coverPath = request()->file('cover')->store('covers', 'public');
            $data['image'] = $coverPath;

            if (! app()->environment('testing')) {
                $this->resizeImage($coverPath);
            }
        }

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

    private function resizeImage($path)
    {
        Image::make(storage_path('app/public/'.$path))->resize(256, 385)->save();
    }
}
