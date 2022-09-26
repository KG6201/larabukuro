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
        return view('mypage', compact('questions', 'answers'));
    }
}
