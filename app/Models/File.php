<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = [
        'reference_id',
        'model',
        'file_path',
        'file_name',
    ];

    protected $appends = [
        'file_path_url'
    ];
    protected function filePathUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => !empty($attributes['file_path']) ? url('') . Storage::url($attributes['file_path']) : null,
        );
    }
}
