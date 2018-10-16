<?php

namespace App\Http\Controllers;

use App\Book;

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
}
