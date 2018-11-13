<?php

namespace App\Http\Controllers\Api;

use App\Author;
use App\Book;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Services\AuthorsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class AuthorsController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new AuthorsService();
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return AuthorResource::collection(Author::paginate(10));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        list($valid, $validationData) = $this->service->validateJsonRequest($request);

        if (! $valid) {
            return response()->json($validationData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author = Author::create($validationData);

        $data = $this->service->createdResponseData($author);

        return response()->json($data)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param Author $author
     * @return AuthorResource
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * @param Request $request
     * @param Author $author
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Author $author)
    {
        list($valid, $validationData) = $this->service->validateJsonRequest($request);

        if (! $valid) {
            return response()->json($validationData, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->update($validationData);

        $data = $this->service->updatedResponseData($author);

        return response()->json($data)->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param Author $author
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Author $author)
    {
        $author->delete();

        $data = $this->service->deletedResponseData();

        return response()->json($data)->setStatusCode(Response::HTTP_OK);
    }

    public function books(Author $author)
    {
        return BookResource::collection(Book::where(['author_id' => $author->id])->paginate(10));
    }
}
