<?php

namespace App\Http\Controllers;

use App\Question;
use App\Candidate;
use App\Vote;

use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index() {
        $questions = Question::with('user')->with('votes')->orderBy('created_at', 'desc')->get();
        // $questions = Question::with('candidates')->orderBy('created_at', 'desc')->get();
        return response($questions, 200);
    }

    public function store(Request $request) {
        $question = new Question;
        $question->title = $request->question;
        $question->user_id = $request->user()->id;
        $result = [ 'status' => 0, 'response' => 'Санал асуулга үүсгэхэд алдаа гарлаа!' ];
        
        if ( $question->save() ) {   
            for ( $i = 0; $i < sizeof($request->candidates); $i++ ) {
                $candidate = new Candidate;
                $candidate->candidate = $request->candidates[$i];
                $candidate->question_id = $question->id;
                $candidate->save();
                $question->candidates->add($candidate);
            }
            $result['status'] = 1;
            $result['response'] = 'Таны нийтлэлийг амжилтай бүртгэллээ!';
        }
        return response($result, 201);
    }

    public function vote_store(Request $request) {
        $result = ['status' => 1, 'msg' => 'Таны сонголт амжилттай хадгаллаа.', 'err' => []];
        for ( $i = 0; $i < sizeof($request->votes); $i++ ) {
            $vote = new Vote;
            $vote->question_id = $request->question;
            $vote->candidate_id = $request->votes[$i];
            $vote->user_id = $request->user()->id;
            if ( !$vote->save() ) {
                $result['status'] = 0;
                $result['msg'] = 'Таны сонголтыг хадгалж чадсангүй дахин санал өгнө үү.';
                array_push($result['err'], $request->votes[$i]);
            }
        }
        return response($result, 201);
    }

    public function show(Request $request) {
        $question = Question::with('user')->with('candidates')->find($request->id);
        return response($question, 200);
    }
}
