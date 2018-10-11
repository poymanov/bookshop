@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row tm-content-row tm-mt-big">
        <div class="tm-col tm-col-big">
            <div class="bg-white tm-block h-100">
                <div class="row">
                    <div class="col-8">
                        <h2 class="tm-block-title d-inline-block">Last authors</h2>

                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('admin.authors.index') }}" class="tm-link-black">View All</a>
                    </div>
                </div>
                <ol class="tm-list-group tm-list-group-alternate-color tm-list-group-pad-big">
                    @foreach($authors as $author)
                        <li class="tm-list-group-item">
                            <a href="{{ route('admin.authors.show', $author) }}">{{ $author->name }}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
@endsection
