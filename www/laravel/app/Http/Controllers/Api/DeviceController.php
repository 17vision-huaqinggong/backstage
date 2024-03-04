<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\DeviceVisit;
use App\Models\DeviceWear;
use Carbon\Carbon;

class DeviceController extends Controller
{
    public function addWears(Request $request)
    {
        $request->validate([
            'scene_uuid' => 'required|string',
            'scene_id' => 'required|integer',
            'scene_name' => 'required|string'
        ],[],[
            'scene_uuid' => '场景 uuid',
            'scene_id' => '场景 id',
            'scene_name' => '场景名字'
        ]);

        $data = $request->only(['scene_uuid', 'scene_id', 'scene_name']);

        $data['date'] = (int)Carbon::now()->format('Ymd');

        $result = DeviceWear::create($data);

        return response()->json($result);
    }

    public function addVisits(Request $request)
    {
        // 如果存在 duration，就是上一个点位的时长
        $request->validate([
            'scene_uuid' => 'required|string',
            'scene_id' => 'required|integer',
            'scene_name' => 'required|string',
            'point_id' => 'required|integer',
            'point_name' => 'required|string',
            'duration' => 'filled|integer'
        ],[],[
            'scene_uuid' => '场景 uuid',
            'scene_id' => '场景 id',
            'scene_name' => '场景名字',
            'point_id' => '点位 id',
            'point_name' => '点位名字',
            'duration' => '停留时长'
        ]);

        $data = $request->only(['scene_uuid', 'scene_id', 'scene_name', 'point_id', 'point_name']);

        $data['date'] = (int)Carbon::now()->format('Ymd');

        if ($request->duration) {
            $result = DeviceVisit::query()->where('scene_uuid', $data['scene_uuid'])->where('scene_id', $data['scene_id'])
                ->orderBy('id', 'desc')->update(['duration' => $request->duration]);


            if (!$result) {
                Log::channel('visits')->error('update duration error', $data);
            }
        }

        $result = DeviceVisit::create($data);

        return response()->json($result);
    }
}
