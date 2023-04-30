@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Asset Request</h1>
<p class="mb-4"></p>

{{-- Asset Request Info --}}
<div class="mb-3">
    <table>
        <tr>
            <td>No. Request</td>
            <td class="px-3">:</td>
            <td>{{ $asset_request->number }}</td>
        </tr>
        <tr>
            <td>Request Date</td>
            <td class="px-3">:</td>
            <td>{{ \Carbon\Carbon::parse($asset_request->date)->format('Y-m-d') }}</td>
        </tr>
    
        <tr>
            <td>Requestor</td>
            <td class="px-3">:</td>
            <td>{{ $asset_request->user->name }}</td>
        </tr>
    
        <tr>
            <td>Department</td>
            <td class="px-3">:</td>
            <td>{{ $asset_request->department->department }}</td>
        </tr>
    
        <tr>
            <td>Office</td>
            <td class="px-3">:</td>
            <td>{{ $asset_request->office->location }}</td>
        </tr>
    </table>
</div>

<!-- Page Alaert -->
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="messageAllert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Asset Request List</h6>
    </div>
    <div class="card-body">
        <div class="mb-4 d-flex justify-content-end">

            @if ($asset_request->status == 'draft' || ($asset_request->status == 'rejected' && Auth::user()->role == 'employee'))
                <a href="{{ route('sub_asset_request.create', $asset_request->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Create Asset
                </a>
                <a href="{{ route('file_asset_request.create', $asset_request->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-3">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Create Attachment
                </a>
            @endif

            @if (
                ($asset_request->status == 'draft' && $asset_request->role_status == 'employee' && Auth::user()->role == 'employee') || 
                ($asset_request->status == 'rejected' && $asset_request->role_status == 'employee' && Auth::user()->role == 'employee')
            )
                <form method="POST" action="{{ route('asset_request.submit', $asset_request->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" value="submit">
                    <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                        <i class="fas fa-paper-plane" fa-sm text-white-50"></i> Submit
                    </button>
                </form>
            @endif

            @if ((Auth::user()->role != 'employee' && $asset_request->role_status == Auth::user()->role) || $asset_request->status == 'finish')
                <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm mr-3" id="rejectedBtn" data-toggle="modal" data-target="#submitModal">
                    Rejected
                </button>

                <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" id="approvedBtn" data-toggle="modal" data-target="#submitModal">
                    Approve
                </button>
            @endif
        </div>

        <div class="mt-3">
            @yield('asset_content')
        </div>
        
    </div>
</div>

<!-- Modal Approve and Reject -->
<div class="modal fade" id="submitModal" tabindex="-1" data-backdrop="static" aria-labelledby="submitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="mb-3">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('asset_request.submit', $asset_request->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" id="statusInput">
                    <div class="mb-3">
                        <label for="commentInput">comment</label>
                        <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" id="commentInput" rows="3">{{ old('comment') }}</textarea>
                        @error('comment')
                        <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm mr-3" data-dismiss="modal">Close</button>
                        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Send</button>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
			$("#approvedBtn").click(function() {
				var value = "approved";
				$("#statusInput").val(value);
			});

            $("#rejectedBtn").click(function() {
				var value = "rejected";
				$("#statusInput").val(value);
			});
		});

    </script>
@endsection