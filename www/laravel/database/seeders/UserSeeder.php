<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Admin;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $remember_token = Str::random(10);
        $phone = 13671638524;
        $password = 111111;
        $nickname = '华清宫';
        $email = 'zhoulin@xiangrong.pro';

        $data = [
            'account' => $phone,
            'password' => Hash::make($password),
            'nickname' => $nickname,
            'phone' => $phone,
            'gender' => 1,
            'email' => $email,
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'remember_token' => $remember_token
        ];
        $user = User::create($data);

        // 创建管理员
        $admin = Admin::create([
            'user_id' => $user->id,
            'username' => $user->nickname,
            'rank' => 1
        ]);
    }
}
