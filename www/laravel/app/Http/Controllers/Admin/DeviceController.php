<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
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
            'days' => 'required|in:0,7,15,30'
        ], [], [
            'scene_id' => '场景 id',
            'days' => '天数'
        ]);

        $scene_id = $request->scene_id;

        $day = Carbon::now()->startOfDay()->subDays($request->days)->toDateTimeString();

        $wears_count = DeviceWear::where('scene_id', $scene_id)->where('created_at', '>=', $day)->count();

        $visits_count = DeviceVisit::where('scene_id', $scene_id)->where('created_at', '>=', $day)->count();

        return response()->json(['wears_count' => $wears_count, 'visits_count' => $visits_count]);
    }

    public function getDetail(Request $request)
    {
        $request->validate([
            'scene_id' => 'required|integer',
            'days' => 'required|in:0,7,15,30'
        ], [], [
            'scene_id' => '场景 id',
            'days' => '天数'
        ]);

        $scene_id = $request->scene_id;

        $day = Carbon::now()->startOfDay()->subDays($request->days)->toDateTimeString();

        // 对日期和小时都进行了分组
        // $wears = DeviceWear::where('scene_id', $scene_id)
        //     ->where('created_at', '>=', $day)
        //     ->selectRaw('DATE(created_at) as date, HOUR(created_at) as hour, COUNT(*) as count')
        //     ->groupByRaw('DATE(created_at), HOUR(created_at)') // 使用 RAW GROUP BY
        //     ->orderBy('date', 'asc')
        //     ->orderBy('hour', 'asc')
        //     ->get(['date', 'hour', 'count']);

        $hours = [9, 10, 11, 12, 13, 14, 15, 16, 17, 18];

        // 佩戴量（只对小时进行分组）
        $wears = DeviceWear::where('scene_id', $scene_id)
            ->where('created_at', '>=', $day)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupByRaw('HOUR(created_at)')
            ->orderBy('hour', 'asc')
            ->get(['hour', 'count'])->toArray();

        $wears = Arr::keyBy($wears, 'hour');

        $temp = [];
        foreach($hours as $hour) {
            if (isset($wears[$hour])) {
                array_push($temp, $wears[$hour]['count']);
            } else {
                array_push($temp, 0);
            }
        }
        $wears = $temp;

        // 访问量
        $visits = DeviceVisit::where('scene_id', $scene_id)
            ->where('created_at', '>=', $day)
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupByRaw('HOUR(created_at)')
            ->orderBy('hour', 'asc')
            ->get(['hour', 'count'])->toArray();

        $visits = Arr::keyBy($visits, 'hour');

        $temp = [];
        foreach($hours as $hour) {
            if (isset($visits[$hour])) {
                array_push($temp, $visits[$hour]['count']);
            } else {
                array_push($temp, 0);
            }
        }
        $visits = $temp;

        return response()->json(['wears' => $wears, 'visits' => $visits]);
    }
}
