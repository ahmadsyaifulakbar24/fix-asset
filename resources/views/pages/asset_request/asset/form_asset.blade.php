@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Asset Request</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $sub_asset_request->exists ? 'Edit' : 'Create'}} Asset Request</h6>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $sub_asset_request->exists ? route('sub_asset_request.update', ['asset_request' => $asset_request_id, 'sub_asset_request' => $sub_asset_request->id]) : route('sub_asset_request.store', $asset_request_id) }}" enctype="multipart/form-data">
            @csrf
            @if($sub_asset_request->exists)
                @method('PUT')
            @endif
            <div class="mb-3">
                <label for="nameInput" class="form-label">Asset Name</label>
                <input type="text" name="asset_name" class="form-control @error('asset_name') is-invalid @enderror" id="nameInput" placeholder="Asset Name" value="{{ old('asset_name', $sub_asset_request->asset_name) }}" required>
                @error('asset_name')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="categoryInput" class="form-label">Category</label>
                <select name="category" class="custom-select @error('category') is-invalid @enderror" id="categoryInput">
                    <option selected>--Select Category--</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category', $sub_asset_request->category_id) == $category->id)>{{ $category->category }}</option>
                    @endforeach
                </select>
                @error('category')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="qtyInput" class="form-label">QTY</label>
                <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror" id="qtyInput" placeholder="QTY" value="{{ old('qty', $sub_asset_request->qty) }}" required>
                @error('qty')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="spesificationInput" class="form-label">Spesification</label>
                <input type="text" name="spesification" class="form-control @error('spesification') is-invalid @enderror" id="spesificationInput" placeholder="Spesification" value="{{ old('spesification', $sub_asset_request->spesification) }}" required>
                @error('spesification')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="modelInput" class="form-label">Model</label>
                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" id="modelInput" placeholder="Model" value="{{ old('model', $sub_asset_request->model) }}" required>
                @error('model')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="purposeInput" class="form-label">Purpose</label>
                <input type="text" name="purpose" class="form-control @error('purpose') is-invalid @enderror" id="purposeInput" placeholder="Purpose" value="{{ old('purpose', $sub_asset_request->purpose) }}" required>
                @error('purpose')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="estimationPriceInput" class="form-label">Estimation Price</label>
                <input type="number" name="estimation_price" class="form-control @error('estimation_price') is-invalid @enderror" id="estimationPriceInput" placeholder="Estimation Price" value="{{ old('estimation_price', $sub_asset_request->estimation_price) }}" required>
                @error('estimation_price')
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