<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelpers;
use App\Models\Department;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $statuses = [
        [
            'value' => '1',
            'name' => 'Active',
        ],
        [
            'value' => '0',
            'name' => 'Not Active',
        ]
    ];

    private $roles = [
        [
            'value' => 'employee',
            'name' => 'Employee',
        ],
        [
            'value' => 'manager',
            'name' => 'Manager',
        ],
        [
            'value' => 'finance',
            'name' => 'Finance',
        ],
        [
            'value' => 'it',
            'name' => 'IT',
        ],
        [
            'value' => 'ga',
            'name' => 'GA',
        ],
        [
            'value' => 'hrga',
            'name' => 'HRGA',
        ],
        [
            'value' => 'presdir',
            'name' => 'Presdir',
        ],
    ];
    
    public function index()
    {
        $users = User::where('role', '!=', 'super-admin')->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.user.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $departments = Department::orderBy('department', 'asc')->get();
        $offices = Location::orderBy('code', 'asc')->get();
        $roles = $this->roles;
        $statuses = $this->statuses;
        return view('pages.user.form_user', compact('user', 'departments', 'offices', 'roles', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'unique:users,code'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'department' => ['required', 'exists:departments,id'],
            'office' => ['required', 'exists:locations,id'],
            'phone_number' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image'],
            'status' => ['required', 'in:1,0'],
            'role' => ['required', 'in:super-admin,employee,manager,finance,it,ga,hrga,presdir'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        $input = $request->except([
            'department',
            'office',
            'password'
        ]);
        $input['password']= Hash::make($request->password);
        $input['department_id'] = $request->department;
        $input['location_id'] = $request->office;

        if($request->photo) {
            $input['photo'] = FileHelpers::upload_file('profile', $request->photo);
        }

        User::create($input);

        return redirect()->route('user')->with('success', 'User Has Been Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $departments = Department::orderBy('department', 'asc')->get();
        $offices = Location::orderBy('code', 'asc')->get();
        $roles = $this->roles;
        $statuses = $this->statuses;

        return view('pages.user.form_user', compact('user', 'departments', 'offices', 'roles', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'code' => ['required', 'unique:users,code,'.$user->id],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'department' => ['required', 'exists:departments,id'],
            'office' => ['required', 'exists:locations,id'],
            'phone_number' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'photo' => ['nullable', 'image'],
            'status' => ['required', 'in:1,0'],
            'role' => ['required', 'in:super-admin,employee,manager,finance,it,ga,hrga,presdir'],
        ]);

        $input = $request->except([
            'department',
            'office'
        ]);
        $input['department_id'] = $request->department;
        $input['location_id'] = $request->office;

        if($request->photo) {
            $input['photo'] = FileHelpers::upload_file('profile', $request->photo);
            if($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
        }

        $user->update($input);

        return redirect()->route('user')->with('success', 'User Has Been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->photo)  {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        return redirect()->route('user')->with('success', 'User Has Been Deleted Successfully');
    }
}
