<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelpers;
use App\Models\ApprovalHistory;
use App\Models\AssetRequest;
use App\Models\Category;
use App\Models\File;
use App\Models\SubAssetRequest;
use App\Models\User;
use App\Notifications\AssetRequestNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssetRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role == 'employee') {
            $asset_requests = AssetRequest::where([
                ['user_id', $user->id],
                ['location_id', $user->location_id]
            ])->orderBy('updated_at', 'desc')->paginate('10');
        } else if ($user->role == 'manager') {
            $asset_requests = AssetRequest::where([
                ['location_id', $user->location_id], 
                ['department_id', $user->department_id],
                ['role_status', 'manager']
            ])->orderBy('updated_at', 'desc')->paginate('10');
        } else {
            $asset_requests = AssetRequest::where([
                ['location_id', $user->location_id],
                ['role_status', $user->role]
            ])->orderBy('updated_at', 'desc')->paginate('10');
        }
        return view('pages.asset_request.asset_request', compact('asset_requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $asset_request = new AssetRequest();
        return view('pages.asset_request.form_asset_request', compact('asset_request'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
        ]);

        $user = Auth::user();

        $input = $request->only(['title']);
        $now = Carbon::now()->format('y-m');
        $now_split = explode('-', $now);
        $input['number'] = 'ASTHSI' . $now_split[0] . $now_split[1] . sprintf('%06d', $this->auto_number());
        $input['date'] = Carbon::now();
        $input['user_id'] = $user->id;
        $input['department_id'] = $user->department_id;
        $input['location_id'] = $user->location_id;
        $input['status'] = 'draft';
        $input['role_status'] = "employee";
        $input['approve_step'] = "employee";
        
        $asset_request = AssetRequest::create($input);
        
        return redirect()->route('asset_request.show', $asset_request->id)->with('success', 'Asset Request Has Been Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetRequest $asset_request)
    {
        $files = File::orderBy('created_at', 'desc')->get();
        $sub_asset_requests = $asset_request->sub_asset_request()->orderBy('created_at', 'asc')->get();
        return view('pages.asset_request.asset.show_asset_request', compact('asset_request', 'sub_asset_requests', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetRequest $asset_request)
    {
        return view('pages.asset_request.form_asset_request', compact('asset_request'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetRequest $asset_request)
    {
        $request->validate([
            'title' => ['required', 'string'],
        ]);

        $input = $request->only(['title']);

        $asset_request->update($input);
        return redirect()->route('asset_request.show', $asset_request->id)->with('success', 'Asset Request Has Been Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetRequest $asset_request)
    {
        $asset_request->delete();
        return redirect()->route('asset_request')->with('success', 'Asset Request Has Been Deleted Successfully');
    }

    public function submit(Request $request, AssetRequest $asset_request) 
    {
        $request->validate([
            'status' => ['required', 'in:submit,rejected,approved'],
            'comment' => ['nullable', 'string'],
        ]);

        
        $user = Auth::user();
        $status = $request->status;
        
        $input = $request->only(['status']);

        // notification
        $user_notification = User::where('location_id', $user->location_id);

        if($status == 'submit' || $status == 'approved') {
            if ($user->role == 'employee') {
                $input['role_status'] = 'manager';
                $user_notification->where([
                    ['department_id', $user->department_id],
                    ['role', 'manager']
                ]);
            } else if ($user->role == 'manager') {
                $input['role_status'] = 'finance';
                $user_notification->where('role', 'finance');
            } else if ($user->role == 'finance') {
                $input['role_status'] = 'it';
                $user_notification->where('role', 'it');
            } else if ($user->role == 'it') {
                $input['role_status'] = 'ga';
                $user_notification->where('role', 'ga');
            } else if ($user->role == 'ga') {
                $input['role_status'] = 'hrga';
                $user_notification->where('role', 'hrga');
            } else if ($user->role == 'hrga') {
                $input['role_status'] = 'presdir';
                $user_notification->where('role', 'presdir');
            } else if ($user->role == 'presdir') {
                $input['role_status'] = 'finish';
                $user_notification->where('id', $asset_request->user_id);
            }
        } else {
            $input['role_status'] = 'employee';
            $user_notification->where('id', $asset_request->user_id);
        }
        $input['approve_step'] = $user->role;

        $asset_request->update($input);
        
        if($status == 'submit') {
            $message = 'Submited';
            $task = 'request';
        } else if ($status == 'approved') {
            $message = 'Approved';
            $task = 'approval';
        } else {
            $message = 'Rejected';
            $task = 'rejected';
        }

        $input_history['asset_request_id'] = $asset_request->id;
        $input_history['task'] = $user->role .' '. $task;
        $input_history['name'] = $user->name;
        $input_history['outcome'] = $request->status;
        $input_history['comment'] = !empty($request->comment) ? $request->comment : '-' ;
        ApprovalHistory::create($input_history);

        

        foreach($user_notification->get() as $user_notif) {
            $user_notif->notify(new AssetRequestNotification($asset_request, $user, $user_notif));
        }

        return redirect()->route('asset_request.show', $asset_request->id)->with('success', 'Asset Has Been '.$message.' Successfully');
    }


    // sub asset request
    public function asset_request_create($asset_request_id) 
    {
        $sub_asset_request = new SubAssetRequest();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.asset_request.asset.form_asset', compact('asset_request_id', 'sub_asset_request', 'categories'));
    }

    public function asset_request_store($asset_request_id, Request $request)
    {
        $request->validate([
            'asset_name' => ['required', 'string'],
            'category' => ['required', 'exists:categories,id'],
            'qty' => ['required', 'numeric'],
            'spesification' => ['required', 'string'],
            'model' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'estimation_price' => ['required', 'integer'], 
        ]);

        $input = $request->except(['category']);
        $input['asset_request_id'] = $asset_request_id;
        $input['category_id'] = $request->category;

        SubAssetRequest::create($input);

        return redirect()->route('asset_request.show', $asset_request_id)->with('success', 'Asset Has Been Created Successfully');
    }

    public function asset_request_edit($asset_request_id, SubAssetRequest $sub_asset_request) 
    {
        // $sub_asset_request = new SubAssetRequest();
        $categories = Category::orderBy('category', 'asc')->get();
        return view('pages.asset_request.asset.form_asset', compact('asset_request_id', 'sub_asset_request', 'categories'));
    }

    public function asset_request_update(Request $request, $asset_request_id, SubAssetRequest $sub_asset_request)
    {
        $request->validate([
            'asset_name' => ['required', 'string'],
            'category' => ['required', 'exists:categories,id'],
            'qty' => ['required', 'numeric'],
            'spesification' => ['required', 'string'],
            'model' => ['required', 'string'],
            'purpose' => ['required', 'string'],
            'estimation_price' => ['required', 'integer'], 
        ]);

        $input = $request->except(['category']);
        $input['category_id'] = $request->category;

        $sub_asset_request->update($input);

        return redirect()->route('asset_request.show', $asset_request_id)->with('success', 'Asset Has Been Updated Successfully');
    }

    public function asset_request_destroy($asset_request_id, SubAssetRequest $sub_asset_request)
    {
        $sub_asset_request->delete();
        return redirect()->route('asset_request.show', $asset_request_id)->with('success', 'Asset Has Been Deleted Successfully');
    }

    public function file_create($asset_request_id, Request $request)
    {
        return view('pages.asset_request.asset.form_file', compact('asset_request_id'));
    }

    public function file_store($asset_request_id, Request $request)
    {
        $request->validate([
            'attachment' => ['required', 'file'],
        ]);

        $input['reference_id'] = $asset_request_id;
        $input['model'] = 'AssetRequest';
        if($request->attachment) {
            $input['file_path'] = FileHelpers::upload_file('asset_attachment', $request->attachment);
            $input['file_name'] = $request->attachment->getClientOriginalName();
        }

        File::create($input);
        return redirect()->route('asset_request.show', $asset_request_id)->with('success', 'File Has Been Created Successfully');
    }

    public function file_destroy($asset_request_id, File $file)
    {
        if($file->file_path) {
            Storage::disk('public')->delete($file->file_path);
        }
        $file->delete();
        
        return redirect()->route('asset_request.show', $asset_request_id)->with('success', 'File Has Been Deleted Successfully');
    }

    protected function auto_number()
    {
        $max_asset_request = AssetRequest::max('id');
        return $max_asset_request + 1;
    }
}
