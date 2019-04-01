<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\VerifyAdmins;
use Illuminate\Auth\Middleware\Authenticate;
use App\Question;
use App\Result;
use Session;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([Authenticate::class,VerifyAdmins::class]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $exams = Question::paginate(10);
        $results = Result::get();
        return view('admin.overview', compact('exams','results'));
    }

    public function setQuest(Request $request){
        $this->validate($request, array(
            'question' => 'required|string',
            'op_one' => 'required|string',
            'op_two' => 'required|string',
            'op_three' => 'required|string',
            'op_four' => 'string',
            'op_five' => 'string',
            'answer' => 'required|string',
        ));

        $answer = $request->answer;
        Question::create([
            'question' => $request->question,
            'op_one' => $request->op_one,
            'op_two' => $request->op_two,
            'op_three' => $request->op_three,
            'op_four' => $request->op_four,
            'op_five' => $request->op_five,
            'answer' => $request->$answer
        ]);
        Session::flash('success', 'Successfully stored exam question');
//        Session::flash('error', 'Payment failed, please try again in a few minutes.');
        return redirect()->route('admin.home');
    }

    public function removeQuest($id){
        $quest = Question::find($id);
        $quest->delete();
        Session::flash('success', 'Successfully delete exam question');
        return redirect()->route('admin.home');
    }

    public function allUserResult(){
        $results = Result::with('user')->orderBy('id','DESC')->get();
        $sn = count($results)+1;
        $results_csv = [];
        foreach ($results as $result){
            $sn = $sn - 1;
            $thedate = date('l\ jS \of F Y h:i A', strtotime($result->created_at));
            $score = $result->correct_questions;
            $totalquest = $result->total_questions;
            $myresult = round(($result->correct_questions/$result->total_questions)*100);
            $grade = $myresult >= 50 ? "passed" : "failed";

            $lineData = array($sn, $thedate, $result->user->name, $result->user->email, $score, $totalquest, $myresult, $grade);
            array_push($results_csv, $lineData);
        }
        $results_csv = json_encode($results_csv);

//        to plot all result over time
        $myscore = Result::get();
        $thedate = [];
        $plotscore = [];

        foreach ($myscore as $score){
            array_push($thedate, date('F', strtotime($score->created_at)));
            array_push($plotscore, intval(round(($score->correct_questions/$score->total_questions)*100)));
        }
        $thedate = json_encode($thedate);
        $plotscore = json_encode($plotscore);

        return view('admin.allresult', compact('results','thedate','plotscore','results_csv'));
    }

    public function exportCsv(){
        # Start the ouput
//        dd(date('Y-m-d h:m:s'));
        $output = fopen("php://output", "w");

        # output headers so that the file is downloaded rather than displayed
        $filename = "results" . date('Y-m-d h:mm:ss') . ".csv";
        header("Content-Type: text/csv");
        header('Content-Disposition: attachment; filename="'.$filename.'";"');
        # Disable caching - HTTP 1.1
        header("Cache-Control: no-cache, no-store, must-revalidate");
        # Disable caching - HTTP 1.0
        header("Pragma: no-cache");
        # Disable caching - Proxies
        header("Expires: 0");

        $delimiter = ",";
        $fields = array('s/n', 'Name', 'Email', 'Score', 'Result (%)', 'Grade');
        fputcsv($output, $fields, $delimiter);

        $results = Result::with('user')->orderBy('id','DESC')->get();
        $sn = 0;
        foreach ($results as $result){
            $sn += 1;
            $score = $result->correct_questions." / ".$result->total_questions;
            $result = round(($result->correct_questions/$result->total_questions)*100);
            $grade = $result >= 50 ? "passed" : "failed";

            $lineData = array($sn, $result->user->name, $result->user->email, $score, $grade);
            fputcsv($output, $lineData, $delimiter);
        }

        # Close the stream off
        fclose($output);
    }
}
