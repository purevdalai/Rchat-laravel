<?php

use App\User;
use App\Room;
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
        factory(User::class, 4)->create()->each(function($user) {
            for ( $i = 0; $i <= 3; $i++ ) {
                $user->news()->save(factory(App\News::class)->make());
            }
            $users = User::all();
            foreach ( $users as $item ) {
                $room = new Room;
                $room->save();
                $room->users()->attach($item);
                $room->users()->attach($user);
            }
        });
    }
}
