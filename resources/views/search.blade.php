@extends('layouts.app')

@section('title')
    Search Results
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="https://www.algolia.com" target="_blank">
                    <img src="/svg/algolia-logo.svg" alt="Algolia" width="200" height="50">
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                @forelse($results as $result)
                    @if($result instanceof \App\Book)
                        <a href="{{ route('books.show', $result) }}"><span class="badge badge-primary">Book</span> {{ $result->title }} ({{ $result->year }}) - {{ $result->isbn }}</a>
                        <p>{{ $result->description }}</p>
                    @elseif($result instanceof \App\Author)
                        <a href="{{ route('authors.show', $result) }}"><span class="badge badge-success">Author</span> {{ $result->name }}</a>
                        <p>{{ $result->description }}</p>
                    @endif
                    <hr>
                @empty
                    <h2>No results</h2>
                @endforelse
                {{ $results->links() }}
            </div>
        </div>
    </div>
@endsection
