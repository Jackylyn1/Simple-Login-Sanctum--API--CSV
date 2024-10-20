<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(2)->make()->each(function($user){
            $password = Str::random(10);
            $user->password = Hash::make($password);
            Log::info('Password for ' . $user->name . ' is ' . $password);
            $user->save();

        });
    }
}
