<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetRequest extends Model
{
    use HasFactory;

    protected $table = 'asset_requests';
    protected $fillable = [
        'title',
        'number',
        'date',
        'user_id',
        'department_id',
        'location_id',
        'status',
        'role_status',
        'approve_step'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function sub_asset_request(): HasMany
    {
        return $this->hasMany(SubAssetRequest::class, 'asset_request_id');
    }

    public function file(): HasMany
    {
        return $this->hasMany(File::class, 'reference_id')->where('model', 'asset_request');
    }

    public function approval_history(): HasMany
    {
        return $this->hasMany(ApprovalHistory::class, 'asset_request_id');
    }
}
