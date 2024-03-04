<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeviceAccess extends Model
{
    use HasFactory;

    protected $fillable = ['scene_uuid', 'scene_id', 'scene_name', 'point_id', 'point_name', 'duration', 'date'];
}
