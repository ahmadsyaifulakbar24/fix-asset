@extends('pages.asset_request.show_asset_request_template')

@section('asset_content')
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Asset Name</th>
                <th>Catgory Asset</th>
                <th>QTY</th>
                <th>Spesification</th>
                <th>Model</th>
                <th>Purpose</th>
                <th>Estimation Price</th>
                <th></th>
            </tr>
        </thead>
        @php
            $asset_no = 1;
            $total_amount = 0;
        @endphp
        <tbody>
            @foreach ($sub_asset_requests as $sub_asset_request)
            @php
                $total_amount +=  $sub_asset_request->estimation_price;
            @endphp
            <tr>
                <td>{{ $asset_no++ }}</td>
                <td>{{ $sub_asset_request->asset_name }}</td>
                <td>{{ $sub_asset_request->category->category }}</td>
                <td>{{ $sub_asset_request->qty }}</td>
                <td>{{ $sub_asset_request->spesification }}</td>
                <td>{{ $sub_asset_request->model }}</td>
                <td>{{ $sub_asset_request->purpose }}</td>
                <td>{{ number_format($sub_asset_request->estimation_price, 0, ",", ".") }}</td>
                <td>
                    @if ($asset_request->status == 'draft')    
                        <form action="{{ route('sub_asset_request.destroy', ['asset_request' => $asset_request->id, 'sub_asset_request' => $sub_asset_request->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ route('sub_asset_request.edit', ['asset_request' => $asset_request->id, 'sub_asset_request' => $sub_asset_request->id]) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
            <tr>
                <td colspan="6"></td>
                <td>Total Amount</td>
                <td>{{ number_format($total_amount,0,",",".") }}</td>
            </tr>
        </tbody>

    </table>

</div>

@if($files->count() != 0)
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>File Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td>
                    <div class="d-flex">
                        <div class="mr-2">
                            {{ $file->file_name }}
                        </div>
                        <form action="{{ route('file_asset_request.destroy', ['asset_request' => $asset_request->id, 'file' => $file->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <a href="{{ $file->file_path_url }}" class="" target="_blank"> view </a>
                            <span>||</span>
                            <button type="submit" class="text-danger btn btn-link p-0" onclick="return checkDelete()">
                                Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>  
@else
    <p>No Attachment</p>
@endif

<!-- Approval History -->
<div class="mt-5">
    <h5>Approval History</h5>
</div>
<div class="table-responsive">
    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Date</th>
                <th>Task</th>
                <th>Name</th>
                <th>Outcome</th>
                <th>Comment</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asset_request->approval_history as $approval_history)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($approval_history->created_at)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $approval_history->task }}</td>
                    <td>{{ $approval_history->name }}</td>
                    <td>{{ $approval_history->outcome }}</td>
                    <td>{{ $approval_history->comment }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection