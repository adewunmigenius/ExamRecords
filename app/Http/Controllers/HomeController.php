<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Result;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exams = Question::paginate(15);
        return view('user.home', compact('exams'));
    }

    public function submit_ans(Request $request){
        $userId = auth()->user()->id;
        $exams = Question::all();

        foreach ($exams as $exam){
            $this->validate($request, array(
                'q'.$exam->id => 'required|integer',
            ));
        }
        $answer = 0;
        $total_qust = count($exams);
        foreach ($exams as $exam) {
            $qid = 'q'.$exam->id;
            $answer += $request->$qid;
        }

//        dd($answer.' / '.$total_qust);

        $result = Result::create([
            'user_id' => $userId,
            'correct_questions' => $answer,
            'total_questions' => $total_qust
        ]);
        $percentage = round(($result->correct_questions/$result->total_questions)*100);

//        to plot all result over time
        $myscore = Result::where("user_id",$userId)->get();
        $thedate = [];
        $plotscore = [];

        foreach ($myscore as $score){
            array_push($thedate, date('F', strtotime($score->created_at)));
            array_push($plotscore, intval(round(($score->correct_questions/$score->total_questions)*100)));
        }

        $thedate = json_encode($thedate);
        $plotscore = json_encode($plotscore);

        return view('user.result', compact('result','percentage','thedate','plotscore'));
    }

    public function userResult($id){
        $userId = auth()->user()->id;
        $result = Result::where([["user_id",$userId],['id',$id]])->first();
        return view('user.result', compact('result'));
    }

    public function allUserResult(){
        $userId = auth()->user()->id;
        $results = Result::where("user_id",$userId)->orderBy('id','DESC')->get();
//        $percentage = round(($result->correct_questions/$result->total_questions)*100);

//        to plot all result over time
        $myscore = Result::where("user_id",$userId)->get();
        $thedate = [];
        $plotscore = [];

        foreach ($myscore as $score){
            array_push($thedate, date('F', strtotime($score->created_at)));
            array_push($plotscore, intval(round(($score->correct_questions/$score->total_questions)*100)));
        }
        $thedate = json_encode($thedate);
        $plotscore = json_encode($plotscore);

        return view('user.allresult', compact('results','thedate','plotscore'));
    }
}
