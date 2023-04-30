@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Category</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $category->exists ? 'Edit' : 'Create'}} Category</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $category->exists ? route('category.update', $category->id) : route('category.store') }}" enctype="multipart/form-data">
            @csrf
            @if($category->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="codeInput" class="form-label">Code</label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="codeInput" placeholder="Category Code" value="{{ old('code', $category->code) }}" required>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categoryInput" class="form-label">Category</label>
                <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" id="categoryInput" placeholder="Category Name" value="{{ old('category', $category->category) }}" required>
                @error('category')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-sm btn-primary shadow-sm">Submit</button>
        </form>
    </div>
</div>
@endsection