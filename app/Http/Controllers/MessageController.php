<?php

namespace App\Http\Controllers;

use Redis;
use App\File as UserFile;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
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
    public function index()
    {
        //
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

    public function files(Request $request)
    {
        $message = new Message;
        $message->content = 'Файлууд';
        $message->room_id = $request->room_id;
        $message->user_id = $request->user()->id;

        $result = [ 'status' => 0, 'response' => 'Таны мессежийг хадгалж чадсангүй!' ];
        
        if ( $message->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Таны мессежийг амжилттай хадгаллаа!';
            $message->user = $request->user();
            $result['message'] = $message;
            // upload files
            
            $files = $request->files;
            $http = 'http://';
            $host = $request->getHttpHost();

            foreach ( $files as $file ) {
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move('files/'.$message->id.'/', $filename);
                $userFile = new UserFile;
                $userFile->path = $http . $host . 'files/'.$message->id.'/' . $imageName;
                $userFile->message_id = $message->id;
                $userFile->save();
            }

            $message['code'] = 'NEW_MESSAGE';
            $this->redis->publish('message', $message);
        }
        return response($result, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Message;
        $message->content = $request->content;
        $message->room_id = $request->room_id;
        $message->user_id = $request->user()->id;
        $result = [ 'status' => 0, 'response' => 'Таны мессежийг хадгалж чадсангүй!' ];
        
        if ( $message->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Таны мессежийг амжилттай хадгаллаа!';
            $message->user = $request->user();
            $result['message'] = $message;
            
            $message['code'] = 'NEW_MESSAGE';
            $this->redis->publish('message', $message);
        }
        return response($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
