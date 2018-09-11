@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    <div class="row">
        @each('book._list', $books, 'book')
    </div>
</div>
@endsection
