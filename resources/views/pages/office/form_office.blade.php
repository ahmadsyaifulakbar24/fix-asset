@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Office</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $office->exists ? 'Edit' : 'Create'}} Office</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $office->exists ? route('office.update', $office->id) : route('office.store') }}" enctype="multipart/form-data">
            @csrf
            @if($office->exists)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="codeInput" class="form-label">Code</label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="codeInput" placeholder="Office Code" value="{{ old('code', $office->code) }}" required>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="officeInput" class="form-label">Office</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="officeInput" placeholder="office Name" value="{{ old('location', $office->location) }}" required>
                @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parentInput" class="form-label">Parent / Branch (Optional)</label>
                <select name="parent" class="custom-select @error('parent') is-invalid @enderror" id="parentInput">
                    <option selected>--Select Parent / Branch--</option>
                    @foreach ($parents as $parent)
                        <option value="{{ $parent->id }}" @selected(old('parent', $office->parent_id) == $parent->id)>{{ $parent->location }}</option>
                    @endforeach
                </select>
                @error('parent')
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