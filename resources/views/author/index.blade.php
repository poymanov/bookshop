@extends('layouts.app')

@section('title')
    Authors
@endsection

@section('content')
<div class="container">
    <div class="row">
        @foreach($authors as $author)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $author->name }}</h5>
                        <p class="card-text">{{ str_limit($author->description) }}</p>
                        <a href="{{ route('authors.show', $author) }}" class="btn btn-primary">Info</a>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12">
            {{ $authors->links() }}
        </div>
    </div>
</div>
@endsection
