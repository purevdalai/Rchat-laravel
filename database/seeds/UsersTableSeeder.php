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
        
        $user1 = [
            'name' => 'Purev Dalai',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('secret'),
        ];

        User::create($user1);


        $user2 = [
            'name' => 'James Robinson',
            'email' => 'system@gmail.com',
            'password' => Hash::make('secret'),
        ];

        User::create($user2);
    }
}
