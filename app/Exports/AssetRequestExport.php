<?php

namespace App\Exports;

use App\Models\AssetRequest;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AssetRequestExport implements FromView
{
    /**
    * @return \Illuminate\Support\FromView
    */

    protected $asset_reqeest;
    public function __construct($asset_reqeest)
    {
        $this->asset_reqeest = $asset_reqeest;
    }

    public function view(): View
    {
        return view('exports.asset_request', [
            'asset_requests' => $this->asset_reqeest,
        ]);
    }
}
