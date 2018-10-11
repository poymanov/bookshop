@extends('layouts.admin')

@section('title')
    Authors
@endsection

@section('content')
    <div class="row tm-content-row tm-mt-big">
        <div class="col-xl-12 col-lg-12 tm-md-12 tm-sm-12 tm-col">
            <div class="bg-white tm-block h-100">
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <h2 class="tm-block-title d-inline-block">Authors</h2>
                    </div>
                    <div class="col-md-4 col-sm-12 text-right">
                        <a href="{{ route('admin.authors.create') }}" class="btn btn-small btn-primary">Add New Author</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped tm-table-striped-even mt-3">
                        <thead>
                            <tr class="tm-bg-gray">
                                <th scope="col">Name</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authors as $author)
                                <tr>
                                    <td class="tm-product-name">{{ $author->name }}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <a class="btn btn-link" href="{{ route('admin.authors.show', $author) }}"><i class="fas fa-eye tm-trash-icon"></i></a>
                                        <a class="btn btn-link" href="{{ route('admin.authors.edit', $author) }}"><i class="far fa-edit tm-trash-icon"></i></a>
                                        <form method="post" class="d-inline" action="{{ route('admin.authors.destroy', $author) }}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-link" type="submit"><i class="fas fa-trash-alt tm-trash-icon"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tm-table-mt tm-table-actions-row">
                    <div class="tm-table-actions-col-left">
                        <nav aria-label="Page navigation" class="d-inline-block">
                            {{ $authors->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
