@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">User</h1>
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
        <h6 class="m-0 font-weight-bold text-primary">User List</h6>
    </div>
    <div class="card-body">
        <div class="mb-4 d-flex justify-content-end">
            <a href="{{ route('user.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Create User
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Office</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                @php
                    $current_page =$users->currentPage();
                    $per_page = $users->perPage();

                    $no = $current_page + ($current_page - 1) * ($per_page - 1);
                @endphp
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->office?->location }}</td>
                            <td>{{ $user->department->department }}</td>
                            <td>{{ $user->status == 1 ? 'Active' : 'Not Active' }}</td>
                            <td>
                                <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('user.edit', $user->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                        <i class="fas fa-pencil-alt fa-sm text-white-50"></i>
                                    </a>

                                    <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="return checkDelete()">
                                        <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection