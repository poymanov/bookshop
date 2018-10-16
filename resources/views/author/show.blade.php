@extends('layouts.app')

@section('title')
    {{ $author->name }}
@endsection

@section('content')
<div class="container">
    <div class="row">
       <div class="col-md-12">
           <h1>{{ $author->name }}</h1>
           <p>{{ $author->description }}</p>
       </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <h2>Books ({{ $author->books()->count() }})</h2>
        </div>
        @each('book._list', $books, 'book')
        <div class="col-md-12">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
