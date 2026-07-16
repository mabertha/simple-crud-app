@extends('layouts.layout')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Category List</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="d-flex" role="search" action="{{ route('category.index')}}" method="GET">
                                    @csrf
                                    <input class="form-control me-2" name="search" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('category.trashed')}}" class="float-end btn btn-warning">Deleted</a>
                                    </div>
                                    <div class="col">
                                        <a href="{{ route('category.create')}}" class="float-end btn btn-success">Add New</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @if (Session::has('success'))
                <span class="alert alert-success p-2">{{ Session::get('success')}}</span>
            @endif
            @if (Session::has('error'))
                <span class="alert alert-danger p-2">{{ Session::get('error')}}</span>
            @endif
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Total Products</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($categories) > 0)
                            @foreach ($categories as $category)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $category->name}}</td>
                                    <td>{{ $category->products_count }}</td>
                                    <td>{{ $category->status}}</td>
                                    <td>
                                        <a href="{{ route('category.show', $category->id) }}" class="btn btn-success btn-sm">show</a>
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary btn-sm">edit</a>
                                        <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')"
                                                class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Data Found!</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection
