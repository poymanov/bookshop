@extends('layouts.admin')

@section('title')
    New book
@endsection

@section('content')
    <div class="row tm-mt-big">
        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12">
            <div class="bg-white tm-block">
                <div class="row">
                    <div class="col-12">
                        <h2 class="tm-block-title d-inline-block">New book</h2>
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
                    <div class="col-xl-8 col-lg-7 col-md-12">
                        <form action="{{ route('admin.books.store') }}" class="tm-edit-product-form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <label for="title" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    Title
                                </label>
                                <input id="title" name="title" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('title') }}">
                            </div>
                            <div class="input-group mb-3">
                                <label for="author_id" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    Author
                                </label>
                                <select id="author_id" name="author_id" class="custom-select col-xl-10 col-lg-8 col-md-8 col-sm-7">
                                    <option></option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ $author->id == old('author_id') ? 'selected' : ''}}>{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group mb-3">
                                <label for="year" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    Year
                                </label>
                                <input id="year" name="year" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('year') }}">
                            </div>
                            <div class="input-group mb-3">
                                <label for="isbn" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    ISBN
                                </label>
                                <input id="isbn" name="isbn" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('isbn') }}">
                            </div>
                            <div class="input-group mb-3">
                                <label for="pages_count" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    Pages
                                </label>
                                <input id="pages_count" name="pages_count" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('pages_count') }}">
                            </div>
                            <div class="input-group mb-3">
                                <label for="price" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 col-form-label">
                                    Price
                                </label>
                                <input id="price" name="price" type="text" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required value="{{ old('price') }}">
                            </div>
                            <div class="input-group mb-3">
                                <label for="description" class="col-xl-2 col-lg-4 col-md-4 col-sm-5 mb-2">Description</label>
                                <textarea id="description" name="description" class="form-control validate col-xl-10 col-lg-8 col-md-8 col-sm-7" required rows="3">{{ old('description') }}</textarea>
                            </div>
                            <div>
                                <input name="cover" id="cover" type="file" style="display:none;" accept="image/*"/>
                            </div>
                            <div class="input-group mb-3">
                                <div class="ml-auto col-xl-10 col-lg-8 col-md-8 col-sm-7 pl-0">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12 mx-auto mb-4">
                        <div class="tm-product-img-dummy mx-auto">
                            <i class="fas fa-5x fa-cloud-upload-alt" onclick="document.getElementById('cover').click();"></i>
                        </div>
                        <div class="custom-file mt-3 mb-3">
                            <input type="button" class="btn btn-primary d-block mx-auto" value="Upload ..." onclick="document.getElementById('cover').click();"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
