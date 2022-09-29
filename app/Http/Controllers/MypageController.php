<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use Auth;

class MypageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $questions = User::query()
            ->find(Auth::user()->id)
            ->userQuestions()
            ->orderBy('updated_at','desc')
            ->get();
        $answers = User::query()
            ->find(Auth::user()->id)
            ->userAnswers()
            ->orderBy('updated_at','desc')
            ->get();
        $solved_question_ids = Question::where('is_solved', 1)->pluck('id')->all();
        // ddd($solved_questions);

        return view('mypage', compact('questions', 'answers', 'solved_question_ids'));
    }
}
