@extends('layouts.admin')

@section('title')
    {{ $author->name }}
@endsection

@section('content')
    <div class="row tm-content-row tm-mt-big">
        <div class="col-xl-12 col-lg-12 tm-md-12 tm-sm-12 tm-col">
            <div class="bg-white tm-block h-100">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h2 class="tm-block-title d-inline-block">{{ $author->name }}</h2>
                        <p>{{ $author->description }}</p>
                    </div>
                </div>
                @if(count($books))
                    <div class="table-responsive">
                        <table class="table table-hover table-striped tm-table-striped-even mt-3">
                            <thead>
                                <tr class="tm-bg-gray">
                                    <th scope="col">Id</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">Pages</th>
                                    <th scope="col">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->year }}</td>
                                        <td>{{ $book->isbn }}</td>
                                        <td>{{ $book->pages_count }}</td>
                                        <td>{{ $book->price }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($books->hasPages())
                        <div class="tm-table-mt tm-table-actions-row">
                            <div class="tm-table-actions-col-left">
                                <nav aria-label="Page navigation" class="d-inline-block">
                                    {{ $books->links() }}
                                </nav>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
