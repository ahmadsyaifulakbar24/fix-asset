<table>
    <thead>
        <tr>
            <th>No. Request</th>
            <th>Request Date</th>
            <th>Requestor</th>
            <th>Department</th>
            <th>Office</th>
            <th>Status</th>

            <th>No</th>
            <th>Name of Asset</th>
            <th>Category Asset</th>
            <th>Qty</th>
            <th>Spesification</th>
            <th>Model</th>
            <th>Purpose</th>
            <th>Estimation Price</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($asset_requests as $asset_request)
            @php
                $no = 1;
            @endphp
            @foreach ($asset_request->sub_asset_request as $sub_asset_request)
                <tr>
                    <td>{{ $asset_request->number }}</td>
                    <td>{{ \Carbon\Carbon::parse($asset_request->date)->format('y-m-d') }}</td>
                    <td>{{ $asset_request->user->name }}</td>
                    <td>{{ $asset_request->department->department }}</td>
                    <td>{{ $asset_request->office->location }}</td>
                    <td>
                        @php
                            $status = ($asset_request->status == 'draft' || $asset_request->status == 'submit') ? $asset_request->status : $asset_request->status . ' by ' . $asset_request->approve_step;
                        @endphp
                        {{ $status }}
                    </td>

                    <td>{{ $no++ }}</td>
                    <td>{{ $sub_asset_request->asset_name }}</td>
                    <td>{{ $sub_asset_request->category->category }}</td>
                    <td>{{ $sub_asset_request->qty }}</td>
                    <td>{{ $sub_asset_request->spesification }}</td>
                    <td>{{ $sub_asset_request->model }}</td>
                    <td>{{ $sub_asset_request->purpose }}</td>
                    <td>{{ number_format($sub_asset_request->estimation_price, 0, ",", ".") }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>