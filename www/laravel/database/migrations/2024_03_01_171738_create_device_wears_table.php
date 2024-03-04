<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // 设备穿戴统计（开机表示）
    // 约定设备在安装包时，生成 scene_uuid
    public function up(): void
    {
        Schema::create('device_wears', function (Blueprint $table) {
            $table->id();
            $table->string('scene_uuid')->comment('场景 uuid')->index();
            $table->unsignedInteger('scene_id')->comment('场景ID')->index();
            $table->string('scene_name')->comment('场景名字，如长恨歌馆');
            $table->unsignedInteger('date')->comment('创建日期， 如20240301');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_wears');
    }
};
