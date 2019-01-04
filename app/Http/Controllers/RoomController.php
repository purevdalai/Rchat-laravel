<?php

namespace App\Http\Controllers;

use Redis;
use App\User;
use App\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    protected $redis;

    function __construct()
    {
        $this->redis = Redis::connection();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = [];
        $user = $request->user();
        $result['rooms'] = $user->rooms;
        return response($result, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new Room;
        $room->name = $request->name;
        $room->description = $request->description;
        $room->type = 3;

        $image = $request->image;
        $http = 'http://';
        $host = $request->getHttpHost();
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move('images/rooms/', $imageName);
        $room->image = $http . $host . '/images/rooms/' . $imageName;
        $result = [ 'status' => 0, 'response' => 'Өрөөг үүсгэхэд алдаа гарлаа!' ];
        if ( $room->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Өрөөг амжилттай үүсгэллээ!';
        }
        $room->users()->attach($request->user(), ['admin' => 1]);
        $users = explode(',', $request->users);
        $room->users()->sync($users, false);
        $room['code'] = 'NEW_ROOM';
        $room['users'] = $room->users;
        $room['user'] = $request->user();
        $this->redis->publish('message', $room);
        return response($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $room = Room::find($request->id);
        $room->messages = $room->messages;
        $room->users = $room->users;
        return response($room, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $room = Room::find($request->id);
        $room->name = $request->name;
        if ( isset($request->description) ) {
            $room->description = $request->description;
        }
        if ( isset($request->image) ) {
            $image = $request->image;
            $http = 'http://';
            $host = $request->getHttpHost();
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move('images/rooms/', $imageName);
            $room->image = $http . $host . '/images/rooms/' . $imageName;
        }
        $result = [ 'status' => 0, 'response' => 'Өрөөний мэдээллийг шинэчлэхэд алдаа гарлаа!' ];
        if ( $room->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Өрөөний мэдээллийг амжилттай шинэчлэв!';
        }
        $room['code'] = 'UPDATE_ROOM';
        $room['users'] = $room->users;
        $room['user'] = $request->user();
        $this->redis->publish('message', $room);
        return response($result, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
