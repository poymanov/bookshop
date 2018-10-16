@extends('layouts.admin')

@section('title')
    {{ $book->title }}
@endsection

@section('content')
    <div class="row tm-content-row tm-mt-big">
        <div class="tm-col tm-col-big">
            <div class="bg-white tm-block">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title d-inline-block">{{ $book->title }}</h2>
                    </div>
                </div>
                <div>
                    <p>
                        <strong>Author:</strong> {{ $book->author->name }}
                    </p>
                    <p>
                        <strong>Year:</strong> {{ $book->year }}
                    </p>
                    <p>
                        <strong>ISBN:</strong> {{ $book->isbn }}
                    </p>
                    <p>
                        <strong>Pages:</strong> {{ $book->pages_count }}
                    </p>
                    <p>
                        <strong>Price:</strong> {{ $book->price }}
                    </p>
                </div>
            </div>
        </div>
        <div class="tm-col tm-col-big">
            <div class="bg-white tm-block">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title">Description</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p>{{ $book->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="tm-col tm-col-small">
            <div class="bg-white tm-block">
                <h2 class="tm-block-title">Cover</h2>
                <img src="{{ $book->image }}" class="img-fluid">
            </div>
        </div>
        {{--<div class="col-xl-12 col-lg-12 tm-md-12 tm-sm-12 tm-col">--}}
            {{--<div class="bg-white tm-block h-100">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-md-8 col-sm-8">--}}
                        {{--<h2 class="tm-block-title d-inline-block">{{ $book->title }}</h2>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<img src="{{ $book->image }}">--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<p><strong>Author:</strong></p>--}}
                            {{--<p>{{ $book->author->name }}</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<p><strong>Description:</strong></p>--}}
                            {{--<p>{{ $book->description }}</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<p><strong>Year:</strong></p>--}}
                            {{--<p>{{ $book->year }}</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<p><strong>ISBN:</strong></p>--}}
                            {{--<p>{{ $book->isbn }}</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<p><strong>Pages:</strong></p>--}}
                            {{--<p>{{ $book->pages_count }}</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        {{--<div>--}}
                            {{--<p><strong>Price:</strong></p>--}}
                            {{--<p>{{ $book->price }} $</p>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
