<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Models\DeviceWear;
use Carbon\Carbon;

class DeviceWearSeeder extends Seeder
{
    public function run(): void
    {
        $scenes = [
            [
                'name' => '长恨歌艺术馆',
                'id' => 1
            ],
            [
                'name' => '珍宝馆',
                'id' => 2
            ],
            [
                'name' => '海棠馆',
                'id' => 3
            ],
            [
                'name' => '莲花汤',
                'id' => 4
            ],
            [
                'name' => '梨园博物馆',
                'id' => 5
            ],
            [
                'name' => '按歌台',
                'id' => 6
            ]
        ];

        $deviceWear = DeviceWear::query()->orderBy('id', 'desc')->first();
        if ($deviceWear) {
            $lastDate = Carbon::parse($deviceWear->created_at);
        }  else {
            $lastDate = Carbon::now()->subDays(25);
        }

        for($i = 0; $i < 400; $i++) {
            $scene = Arr::random($scenes);

            $minutes = rand(30, 100);

            $lastDate->addMinutes($minutes);

            // 如果当前时间小于等于插入的时间，就跳出不搞了
            if (Carbon::now()->lte($lastDate)) {
                break;
            }

            DeviceWear::create([
                'scene_uuid' => '85288F8D-6B48-BBE8-4D78-8322862D0D32',
                'scene_id' => $scene['id'],
                'scene_name' => $scene['name'],
                'date' => (int)$lastDate->format('Ymd'),
                'created_at' => $lastDate->toDateTimeString()
            ]);
        }
    }
}
