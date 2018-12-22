<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 25)->create()->each(function($user) {
            for ( $i = 0; $i <= 3; $i++ ) {
                $user->news()->save(factory(App\News::class)->make());
            }
        });
    }
}
