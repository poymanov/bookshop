<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::getLast();

        return view('home', compact('books'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        $query = request('query');
        $page = request('page', 1);

        $books = Book::search($query)->get();
        $authors = Author::search($query)->get();

        $results = $books->merge($authors);
        $results = $this->paginate($results, 15, $page);
        $results->setPath(route('search', ['query' => $query]));

        return view('search', compact('results'));
    }

    private function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
