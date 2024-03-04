<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeviceVisit;
use App\Models\DeviceWear;
use Carbon\Carbon;

class DeviceController extends Controller
{
    public function getBase(Request $request)
    {
        $request->validate([
            'scene_id' => 'required|integer',
            'days' => 'requred|in:1,7,15,30'
        ],[],[
            'scene_id' => '场景 id',
            'days' => '天数'
        ]);

        $scene_id = $request->scene_id;

        $day = Carbon::now()->subDays($request->days);

        $wears_count = DeviceWear::where('scene_id', $scene_id)->where('created_at', '>=', $day)->count();

        $visits_count = DeviceVisit::where('scene_id', $scene_id)->where('created_at', '>=', $day)->count();

        return response()->json(['wears_count' => $wears_count, 'visits_count' => $visits_count]);
    }

    public function getDetail(Request $request)
    {
        $request->validate([
            'scene_id' => 'required|integer',
            'days' => 'requred|in:1,7,15,30'
        ],[],[
            'scene_id' => '场景 id',
            'days' => '天数'
        ]);

        $scene_id = $request->scene_id;

        $day = Carbon::now()->subDays($request->days);

        $wears = DeviceWear::where('scene_id', $scene_id)->where('created_at', '>=', $day)
            ->selectRaw('DATE(created_at) as date, HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('date', 'hour')
            ->orderBy('date', 'asc')
            ->orderBy('hour', 'asc')
            ->get(['date', 'hour', 'count']);


        $visits = DeviceVisit::where('scene_id', $scene_id)->where('created_at', '>=', $day)
            ->selectRaw('DATE(created_at) as date, HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('date', 'hour')
            ->orderBy('date', 'asc')
            ->orderBy('hour', 'asc')
            ->get(['date', 'hour', 'count']);

        return response()->json(['wears' => $wears, 'visits' => $visits]);
    }
}
