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
            
            $ownRoom = new Room;
            $ownRoom = 1;
            $ownRoom->save();
            $ownRoom->users()->attach($user);

            $users = User::all();
            foreach ( $users as $item ) {
                if ( $user->id < $item->id ) {
                    $room = new Room;
                    $room->type = 2;
                    $room->save();
                    $room->users()->attach($item);
                    $room->users()->attach($user);
                }
            }
        });
    }
}
