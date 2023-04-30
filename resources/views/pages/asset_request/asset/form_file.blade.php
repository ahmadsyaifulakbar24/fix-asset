@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Asset Request</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Create Asset Request</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('file_asset_request.store', $asset_request_id) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="attachment">Attachment</label>
                <input name="attachment" type="file" class="form-control-file @error('attachment') is-invalid @enderror" id="attachment">
                @error('attachment')
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