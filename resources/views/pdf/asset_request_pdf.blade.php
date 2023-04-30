<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asset Request PDF</title>

    <style>
        .table-bordered {
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center
        }

        .text-start {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .underline {
            text-decoration: underline;
        }

        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
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

    {{-- title --}}
    <div class="text-center">
        <h4 class="underline">ASSET PURCHASE REQUEST FORM</h4>
    </div>

    {{-- Asset List --}}
    <div class="">
        <table class="table-bordered" width="100%">
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
                </tr>
            </thead>
            @php
                $asset_no = 1;
                $total_amount = 0;
            @endphp
            <tbody>
                @foreach ($asset_request->sub_asset_request as $sub_asset_request)
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
                </tr>
                @endforeach
                <tr>
                    <td colspan="6"></td>
                    <td class="bold">Total Amount</td>
                    <td class="bold">{{ number_format($total_amount,0,",",".") }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Approval History -->
    <h5 class="underline">Approval History</h5>
    <div class="" style="font-size: 13px">
        <table class="" width="100%">
            <thead>
                <tr>
                    <th class="text-start">Date</th>
                    <th class="text-start">Task</th>
                    <th class="text-start">Name</th>
                    <th class="text-start">Outcome</th>
                    <th class="text-start">Comment</th>
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

        <p class="text-danger">
            * Disclaimer: This is electronic approval no need to sign
        </p>
    </div>
</body>
</html>