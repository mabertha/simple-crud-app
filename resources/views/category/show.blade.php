@extends('layouts.layout')
@section('content')
    <div class="container">
        <h2>Category Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> {{ $category->name }}</p>
                <p><strong>Total Products:</strong> {{ $category->products_count ?? $category->products()->count() }}</p>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($category->status) }}
                    </span>
                </p>

                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('category.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>

@endsection
