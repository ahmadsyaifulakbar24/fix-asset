<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'locations';
    protected $fillable = [
        'code',
        'location',
        'parent_id'
    ];

    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function parentChild()
    {
        return $this->hasMany(Location::class, 'parent_id');
    }
}
