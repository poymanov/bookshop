@extends('layouts.admin')

@section('title')
    {{ $book->title }}
@endsection

@section('content')
    <div class="row tm-content-row tm-mt-big">
        <div class="col-xl-12 col-lg-12 tm-md-12 tm-sm-12 tm-col">
            <div class="bg-white tm-block h-100">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h2 class="tm-block-title d-inline-block">{{ $book->title }}</h2>
                        <hr>
                        <div>
                            <p><strong>Author:</strong></p>
                            <p>{{ $book->author->name }}</p>
                        </div>
                        <hr>
                        <div>
                            <p><strong>Description:</strong></p>
                            <p>{{ $book->description }}</p>
                        </div>
                        <hr>
                        <div>
                            <p><strong>Year:</strong></p>
                            <p>{{ $book->year }}</p>
                        </div>
                        <hr>
                        <div>
                            <p><strong>ISBN:</strong></p>
                            <p>{{ $book->isbn }}</p>
                        </div>
                        <hr>
                        <div>
                            <p><strong>Pages:</strong></p>
                            <p>{{ $book->pages_count }}</p>
                        </div>
                        <hr>
                        <div>
                            <p><strong>Price:</strong></p>
                            <p>{{ $book->price }} $</p>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
