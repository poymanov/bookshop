@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img class="card-img-top" src="{{ $book->image }}" alt="{{ $book->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ str_limit($book->description) }}</p>
                        <a href="{{ route('books.show', $book) }}" class="btn btn-primary">{{ $book->price }} $</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
