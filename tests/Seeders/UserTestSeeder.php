<?php

namespace Tests\Unit\Seeders;

// use App\Modules\Seguridad\Models\User;

use App\User;
use Illuminate\Database\Seeder;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $user = User::where('email', env('UNIT_TEST_USERNAME'))->first();
        if (!isset($user)) {
            factory(User::class)->create(['email' => env('UNIT_TEST_USERNAME'), 'password' => bcrypt(env('UNIT_TEST_PASSWORD')), 'is_active' => true]);
        }
    }
}
