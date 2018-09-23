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
    @if(count($books))
        <div class="row">
            <div class="col-md-12">
                <table class="table table-light">
                    <thead>
                        <tr>
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
                            <td scope="row">{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->year }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->pages_count }}</td>
                            <td>{{ $book->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
