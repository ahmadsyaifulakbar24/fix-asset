<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalHistory extends Model
{
    use HasFactory;

    protected $table = 'approval_histories';
    protected $fillable = [
        'asset_request_id',
        'task',
        'name',
        'outcome',
        'comment'
    ];

    public function asset_request(): BelongsTo
    {
        return $this->belongsTo(AssetRequest::class, 'asset_request_id');
    }
}
