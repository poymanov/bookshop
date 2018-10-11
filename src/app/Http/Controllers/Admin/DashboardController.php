<?php

namespace App\Http\Controllers\Admin;

use App\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $authors = Author::take(7)->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard.index', compact('authors'));
    }
}
