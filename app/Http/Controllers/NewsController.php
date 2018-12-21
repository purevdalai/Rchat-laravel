<?php

namespace App\Http\Controllers;

use App\User;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        return response($news, 200);
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
        $news = new News;
        $image = $request->image;
        $host = $request->getHttpHost();
        $https = 'http://';

        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move('images/news/', $imageName);

        $news->image = $https . $host . '/images/news/' . $imageName;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->user_id = $request->user()->id;
        
        $result = [ 'status' => 0, 'response' => 'Файл хуулахад алдаа гарлаа!' ];

        if ( $news->save() ) {
            $result['status'] = 1;
            $result['response'] = 'Таны нийтлэлийг амжилтай бүртгэллээ!';
        }

        return response($result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $news = News::find($request->id);
        $response['article'] = $news;
        $response['user'] = $news->user;
        return response($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        //
    }
}
