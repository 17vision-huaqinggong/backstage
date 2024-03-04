<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceWear extends Model
{
    use HasFactory;

    protected $fillable = ['scene_uuid', 'scene_id', 'scene_name', 'date'];
}
