<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubAssetRequest extends Model
{
    use HasFactory;

    protected $table = 'sub_asset_requests';
    protected $fillable = [
        'asset_request_id',
        'asset_name',
        'category_id',
        'qty',
        'spesification',
        'model',
        'purpose',
        'estimation_price',
    ];

    public function asset_request(): BelongsTo
    {
        return $this->belongsTo(AssetRequest::class, 'asset_request_id');
    }

     public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
     }
}
