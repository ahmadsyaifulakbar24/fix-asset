@extends('layouts.dashboard')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">User</h1>
<p class="mb-4"></p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">{{ $user->exists ? 'Edit' : 'Create'}} User</h6>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ $user->exists ? route('user.update', $user->id) : route('user.store') }}" enctype="multipart/form-data">
            @csrf
            @if($user->exists)
                @method('PUT')
            @endif

            <div class="mv-3">
                <img src="{{ $user->photo_url ? $user->photo_url : asset('img/profile.png') }}" class="rounded" id="showPhoto"s alt="..." style="width:250px">
            </div>

            <div class="mb-3">
                <label for="photoInput">Photo</label>
                <input name="photo" type="file" class="form-control-file @error('photo') is-invalid @enderror" id="photoInput">
                @error('photo')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="codeInput" class="form-label">Code</label>
                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="codeInput" placeholder="user Code" value="{{ old('code', $user->code) }}" required>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nameInput" class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="nameInput" placeholder="Name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" placeholder="Email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="departmentInput" class="form-label">Department</label>
                <select name="department" class="custom-select @error('department') is-invalid @enderror" id="departmentInput">
                    <option selected>--Select Department--</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department', $user->department_id) == $department->id)>{{ $department->department }}</option>
                    @endforeach
                </select>
                @error('department')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="officeInput" class="form-label">Office</label>
                <select name="office" class="custom-select @error('office') is-invalid @enderror" id="officeInput">
                    <option selected>--Select Office--</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}" @selected(old('office', $user->location_id) == $office->id)>{{ $office->code }} - {{ $office->location }}</option>
                    @endforeach
                </select>
                @error('office')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phoneInput" class="form-label">Phone Number</label>
                <input type="number" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phoneInput" placeholder="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                @error('phone_number')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="addressInput">Address</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="addressInput" rows="3">{{ old('address', $user->address) }}</textarea>
                @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="statusInput" class="form-label">Status</label>
                <select name="status" class="custom-select @error('status') is-invalid @enderror" id="statusInput" required>
                    <option selected>--Select Status--</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status['value'] }}" @selected(old('status', $user->status) == $status['value'])>{{ $status['name'] }}</option>
                    @endforeach
                </select>
                @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="roleInput" class="form-label">Role</label>
                <select name="role" class="custom-select @error('role') is-invalid @enderror" id="roleInput" required>
                    <option selected>--Select Role--</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role['value'] }}" @selected(old('role', $user->role) == $role['value'])>{{ $role['name'] }}</option>
                    @endforeach
                </select>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>

            @if(!$user->exists)
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput" placeholder="Password" required>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
    
                <div class="mb-3">
                    <label for="passwordConfirmInput" class="form-label">Password Confirmation</label>
                    <input type="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="passwordConfirmInput" placeholder="password_confirmation" required>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                </div>
            @endif

            <button type="submit" class="btn btn-sm btn-primary shadow-sm">Submit</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(()=>{
        $('#photoInput').change(function(){
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event){
                    $('#showPhoto').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection