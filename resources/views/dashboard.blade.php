@extends('layouts.dashboard')

@section('style')
    <style>
        .total-font {
            font-weight: bold;
            font-size: 50px;
            margin: 0;
        }
        .fa-icon {
            font-size: 70px;
        }
    </style>
@endsection
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="d-flex">
        <div class="col-lg-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="total-font"> {{ $data['total_asset_request'] }} </div>
                        <div>
                            <i class="fas fa-fw fa-warehouse fa-icon"></i>
                        </div>
                    </div>
                    <p class="card-text">Total Asset Request</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="total-font"> {{ $data['approved_asset_request'] }} </div>
                        <div>
                            <i class="far fa-fw fa-thumbs-up fa-icon"></i>
                        </div>
                    </div>
                    <p class="card-text">Total Asset Approved</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="total-font"> {{ $data['rejected_asset_request'] }} </div>
                        <div>
                            <i class="far fa-fw fa-times-circle fa-icon"></i>
                        </div>
                    </div>
                    <p class="card-text">Total Asset Rejected</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="total-font"> {{ $data['progress_asset_request'] }} </div>
                        <div>
                            <i class="fa fa-fw fa-tasks fa-icon"></i>
                        </div>
                    </div>
                    <p class="card-text">Total Asset Progress</p>
                </div>
            </div>
        </div>
    </div>


@endsection