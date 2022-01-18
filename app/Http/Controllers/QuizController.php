<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getQuizzes(){
        return Quiz::all();
    }


    public function getQuiz($quizId){
        return Quiz::find($quizId);
    }


    public function addQuiz(Request $request){
        $quiz = new Quiz();
        $quiz -> users_id = 0;
        $quiz -> label = $request->get('label');
        $quiz -> published = $request->get('published');
        $quiz -> save();
        return response()->json("Quiz created successfully", 200);
    }


    public function editQuiz(Request $request, $quizId){
        $quiz = Quiz::find($quizId);
        $quiz -> label = $request->get('label');
        $quiz -> published = $request->get('published');
        $quiz -> save();
        return response()->json("Quiz edited successfully", 200);
    }


    public function removeQuiz($quizId){
        $quiz = Quiz::find($quizId);
        $quiz->delete();
        return response()->json("Quiz deleted", 200);
    }


    public function publishQuiz($quizId){
        $quiz = Quiz::find($quizId);
        if($quiz){
            $quiz-> published = 1;
            $quiz->save();
            return response()->json("Quiz published", 200);
        }else{
            return response()->json("Quiz not found", 404);
        }
    }


    public function unpublishQuiz($quizId){
        if($quizId){
            $quiz = Quiz::find($quizId);
            $quiz-> published = 0;
            $quiz->save();
            return response()->json("Quiz unpublished", 200);
        }else{
            return response()->json("Quiz not found", 404);
        }
    }


    public function getQuestions($quizId){
        return response()->json(Quiz::find($quizId)->questions()->get(), 200);
    }


    public function submitQuiz(Request $request, $quizId){

    }


}
