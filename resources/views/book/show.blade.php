@extends('layouts.app')

@section('title')
    {{ $book->title }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <img src="{{ $book->image }}" alt="{{ $book->title }}">
        </div>
        <div class="col-md-9">
            <h1 class="mb-3">{{ $book->title }}</h1>
            <p><strong>Author:</strong> <a href="{{ route('authors.show', $book->author) }}" target="_blank">
                    {{ $book->author->name }}</a>
            </p>
            <p><strong>Year:</strong> {{ $book->year }}</p>
            <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
            <p><strong>Pages:</strong> {{ $book->pages_count }}</p>

            <div>
                <h3>Description:</h3>
                <p>{{ $book->description }}</p>
            </div>

            <div>
                <h3>Price: {{ $book->price }} $</h3>
            </div>
        </div>
    </div>
</div>
@endsection
