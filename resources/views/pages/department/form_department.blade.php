@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Department</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $department->exists ? 'Edit' : 'Create'}} Department</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $department->exists ? route('department.update', $department->id) : route('department.store') }}" enctype="multipart/form-data">
            @csrf
            @if($department->exists)
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="departmetInput" class="form-label">Department</label>
                <input type="text" name="department" class="form-control @error('department') is-invalid @enderror" id="departmetInput" placeholder="Department Name" value="{{ old('department', $department->department) }}" required>
                @error('department')
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