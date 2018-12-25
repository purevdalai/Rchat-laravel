<?php

namespace App\Http\Controllers;

use App\User;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response($users, 200);
    }

    public function store(Request $request) {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role_id = $request->role;
        $user->password = Hash::make($request->password);
        $user->code =  'CODE'.rand(1000,9999);

        $image = $request->image;
        $http = 'http://';
        $host = $request->getHttpHost();
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move('images/users/', $imageName);
        $user->profile_img = $http . $host . '/images/users/' . $imageName;
        
        $result = [ 'status' => 0, 'response' => 'Хэрэглэгч үүсгэх явцад алдаа гарлаа!' ];

        if ( $user->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Хэрэглэгчийг амжилттай үүсгэллээ!';
            
            $ownRoom = new Room;
            $ownRoom->type = 1;
            $ownRoom->save();
            $ownRoom->users()->attach($user, ['admin' => 1]);

            $users = User::all();
            foreach ( $users as $item ) {
                $room = new Room;
                $room->type = 2;
                $room->save();
                $room->users()->attach($item);
                $room->users()->attach($user);
            }
        }
        return response($result, 201);
    }
}
