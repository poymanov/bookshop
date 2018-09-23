@extends('layouts.app')

@section('title')
    Authors
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Authors</h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <a class="btn btn-primary" href="{{ route('admin.authors.create') }}">New author</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-light">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td scope="row">{{ $author->id }}</td>
                        <td>{{ $author->name }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.authors.show', $author) }}">view</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('admin.authors.edit', $author) }}">update</a>
                            <form method="post" class="d-inline" action="{{ route('admin.authors.destroy', $author) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm">delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            {{ $authors->links() }}
        </div>
    </div>
</div>
@endsection