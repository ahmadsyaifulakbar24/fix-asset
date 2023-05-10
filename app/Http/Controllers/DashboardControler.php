<?php

namespace App\Http\Controllers;

use App\Models\AssetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControler extends Controller
{
    public function index() {
        
        $user = Auth::user();
        if($user->role == 'employee') {
            $total_asset_request = AssetRequest::where([['user_id', $user->id], ['status', '!=', 'draft']])->count();
            $approved_asset_request = AssetRequest::where([['user_id', $user->id], ['role_status', 'finish']])->count();
            $rejected_asset_request = AssetRequest::where([['user_id', $user->id], ['status', 'rejected']])->count();
            $progress_asset_request = AssetRequest::where([['user_id', $user->id], ['role_status', '!=', 'finish']])->where(function($query) {
                $query->where('status' , 'submit')->orWhere('status', 'approved')->orWhere('status', 'revision');
            })->count();

        } else if($user->role == 'manager') {
            $total_asset_request = AssetRequest::where([['department_id', $user->department_id], ['status', '!=', 'draft']])->count();
            $approved_asset_request = AssetRequest::where([['department_id', $user->department_id], ['role_status', 'finish']])->count();
            $rejected_asset_request = AssetRequest::where([['department_id', $user->department_id], ['status', 'rejected']])->count();
            $progress_asset_request = AssetRequest::where([['department_id', $user->department_id], ['role_status', '!=', 'finish']])->where(function($query) {
                $query->where('status' , 'submit')->orWhere('status', 'approved')->orWhere('status', 'revision');
            })->count();
        } else {
            $total_asset_request = AssetRequest::where([['location_id', $user->location_id], ['status', '!=', 'draft']])->count();
            $approved_asset_request = AssetRequest::where([['location_id', $user->location_id], ['role_status', 'finish']])->count();
            $rejected_asset_request = AssetRequest::where([['location_id', $user->location_id], ['status', 'rejected']])->count();
            $progress_asset_request = AssetRequest::where([['location_id', $user->location_id], ['role_status', '!=', 'finish']])->where(function($query) {
                $query->where('status' , 'submit')->orWhere('status', 'approved')->orWhere('status', 'revision');
            })->count();
        }

        $data = [
            'total_asset_request' => $total_asset_request,
            'approved_asset_request' => $approved_asset_request,
            'rejected_asset_request' => $rejected_asset_request,
            'progress_asset_request' => $progress_asset_request,
        ];

        return view('dashboard', compact('data'));
    }
}
