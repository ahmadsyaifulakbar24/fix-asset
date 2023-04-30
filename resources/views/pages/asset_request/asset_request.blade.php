@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Asset Request</h1>
<p class="mb-4"></p>

<!-- Page Alaert -->
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="messageAllert">
        {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Asset Request List</h6>
    </div>
    <div class="card-body">
        @if (Auth::user()->role == 'employee')
            <div class="mb-4 d-flex justify-content-end">
                <a href="{{ route('asset_request.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> Create Asset Request
                </a>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Request</th>
                        <th>Title</th>
                        <th>Request Date</th>
                        <th>Requestor</th>
                        <th>Department</th>
                        <th>Office</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                @php
                    $current_page =$asset_requests->currentPage();
                    $per_page = $asset_requests->perPage();

                    $no = $current_page + ($current_page - 1) * ($per_page - 1);
                @endphp
                <tbody>
                    @foreach ($asset_requests as $asset_request)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            <a href="{{ route('asset_request.show', $asset_request->id) }}">
                                {{ $asset_request->number }}
                            </a>
                        </td>
                        <td>{{ $asset_request->title }}</td>
                        <td>{{ \Carbon\Carbon::parse($asset_request->date)->format('Y-m-d') }}</td>
                        <td>{{ $asset_request->user->name }}</td>
                        <td>{{ $asset_request->department->department }}</td>
                        <td>{{ $asset_request->office->location }}</td>
                        <td>
                            @php

                                $status = ($asset_request->status == 'draft' || $asset_request->status == 'submit') ? $asset_request->status : $asset_request->status . ' by ' . $asset_request->approve_step;
                            @endphp
                            {{ $status }}
                        </td>
                        <td>
                            @if ($asset_request->status == 'draft' || ($asset_request->status == 'rejected' && Auth::user()->role == 'employee'))
                                <form action="{{ route('asset_request.destroy',$asset_request->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('asset_request.edit', $asset_request->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-pencil-alt fa-sm text-white-50"></i>
                                    </a>

                                    <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return checkDelete()">
                                        <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            {{ $asset_requests->links() }}
        </div>
    </div>
</div>
@endsection