<?php

namespace App\Http\Controllers\Api;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BooksService;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;

class BooksController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new BooksService();
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookResource::collection(Book::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($valid, $validationData) = $this->service->validateJsonRequest($request);

        if (! $valid) {
            return response()->json($validationData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->service->processImageUpload($request, $validationData);

        $book = Book::create($data);

        $data = $this->service->createdResponseData($book);

        return response()->json($data)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        list($valid, $validationData) = $this->service->validateJsonRequest($request);

        if (! $valid) {
            return response()->json($validationData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->service->processImageUpload($request, $validationData);

        $book->update($data);

        $data = $this->service->updatedResponseData($book);

        return response()->json($data)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        $data = $this->service->deletedResponseData($book);

        return response()->json($data)->setStatusCode(Response::HTTP_OK);
    }
}
