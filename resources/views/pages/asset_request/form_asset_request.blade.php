@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Asset Request</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $asset_request->exists ? 'Edit' : 'Create'}} Asset Request</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $asset_request->exists ? route('asset_request.update', $asset_request->id) : route('asset_request.store') }}" enctype="multipart/form-data">
            @csrf
            @if($asset_request->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="titleInput" class="form-label">Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="titleInput" placeholder="Title" value="{{ old('title', $asset_request->title) }}" required>
                @error('title')
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