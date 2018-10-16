@extends('layouts.admin')

@section('title')
    New author
@endsection

@section('content')
<div class="row tm-mt-big">
    <div class="col-xl-6 col-lg-10 col-md-12 col-sm-12">
        <div class="bg-white tm-block">
            <div class="row">
                <div class="col-12">
                    <h2 class="tm-block-title d-inline-block">New author</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if(count($errors))
                        <ul class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="row mt-4 tm-edit-product-row">
                <div class="col-xl-12 col-lg-7 col-md-12">
                    <form action="{{ route('admin.authors.store') }}" class="tm-edit-product-form" method="post">
                        {{ csrf_field() }}
                        <div class="input-group mb-3">
                            <label for="name" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                Name
                            </label>
                            <input id="name" name="name" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('name') }}">
                        </div>
                        <div class="input-group mb-3">
                            <label for="description" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 mb-2">Description</label>
                            <textarea name="description" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="input-group mb-3">
                            <div class="ml-auto col-xl-10 col-lg-8 col-md-8 col-sm-7 pl-0">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
