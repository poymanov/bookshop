@extends('layouts.app')

@section('title')
    New author
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>New author</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(count($errors))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('admin.authors.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="form-control" id="title" value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection