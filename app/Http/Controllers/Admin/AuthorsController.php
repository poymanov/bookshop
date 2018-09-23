<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::paginate(12);
        return view('admin.author.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $author = Author::create([
            'name' => request('name'),
            'description' => request('description')
        ]);

        return redirect(route('admin.authors.show', $author));
    }

    /**
     * Display the specified resource.
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Author $author)
    {
        $books = $author->books()->paginate(12);
        return view('admin.author.show', compact('author', 'books'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Author $author
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Author $author)
    {
        return view('admin.author.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     * @param Author $author
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Author $author)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $author->update([
            'name' => request('name'),
            'description' => request('description')
        ]);

        return redirect(route('admin.authors.show', $author));
    }

    /**
     * Remove the specified resource from storage.
     * @param Author $author
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect(route('admin.authors.index'));
    }
}
