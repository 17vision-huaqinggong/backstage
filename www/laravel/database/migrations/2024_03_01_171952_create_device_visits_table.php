<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // 设备访问统计（进入节点算一次）
    public function up(): void
    {
        Schema::create('device_visits', function (Blueprint $table) {
            $table->id();
            $table->string('scene_uuid')->comment('场景 uuid')->index();
            $table->unsignedInteger('scene_id')->comment('场景ID')->index();
            $table->string('scene_name')->comment('场景名字，如长恨歌馆');
            $table->unsignedInteger('point_id')->comment('点位 id')->index();
            $table->string('point_name')->comment('点位名字');
            $table->unsignedSmallInteger('duration')->nullable()->comment('停留时长');
            $table->unsignedInteger('date')->comment('创建日期， 如20240301');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('device_accesses');
    }
};
