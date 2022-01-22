<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getUser($userId){
        return User::find($userId);
    }

    public function getQuizzes(){
        return Quiz::all();
    }

    public function getQuiz($quizId){
        return Quiz::find($quizId);
    }

    public function getQuestions($quizId){
        return response()->json(Quiz::find($quizId)->questions()->get(), 200);
    }

    public function addQuiz(Request $request){
        $data = json_decode($request->getContent(), true);
        $quiz = new Quiz();

        $quiz -> user_id = 0;
        $quiz -> label = $data['label'];
        $quiz -> published = $data['published'];
        $quiz -> save();

        foreach($data['questions'] as $data_question)
        {
            $question = new Question();
            $question -> id = $data_question['id'];
            $question -> label = $data_question['label'];
            $question -> earnings = $data_question['earnings'];
            $question -> answer = $data_question['answer'];

            $question -> quiz_id = $quiz ->id;

            foreach($data_question['choices'] as $data_choice)
            {
                $choice = new Choice();

                $choice -> question_id = $data_question['id'];
                $choice -> id = $data_choice['id'];
                $choice -> label = $data_choice['label'];

                $choice -> save();
            }

            $question ->save();
        }
        return response()->json("Quiz created successfully", 200);
    }


    public function editQuiz(Request $request, $quizId){
        $data = json_decode($request->getContent(), true);
        $quiz = Quiz::find($quizId);

        $quiz -> label = $data['label'];
        $quiz -> published = $data['published'];
        $quiz -> save();

        $questions = Question::where('quiz_id', $quizId)->get();
        foreach($questions as $question){
            $choices = Choice::where('question_id', $question -> id)->get();
            foreach($choices as $choice){
                $choice-> delete();
            }
            $question -> delete();
        }

        foreach($data['questions'] as $data_question)
        {
            $question = new Question();
            $question -> id = $data_question['id'];
            $question -> label = $data_question['label'];
            $question -> earnings = $data_question['earnings'];
            $question -> answer = $data_question['answer'];

            $question -> quiz_id = $quiz ->id;

            foreach($data_question['choices'] as $data_choice)
            {
                $choice = new Choice();

                $choice -> question_id = $data_question['id'];
                $choice -> id = $data_choice['id'];
                $choice -> label = $data_choice['label'];

                $choice -> save();
            }

            $question ->save();
        }
        return response()->json("Quiz edited successfully", 200);
    }

    public function removeQuiz($quizId){
        $quiz = Quiz::find($quizId);

        $scores = Score::where('quiz_id', $quizId)->get();
        foreach($scores as $score){
            $score-> delete();
        }

        $questions = Question::where('quiz_id', $quizId)->get();
        foreach($questions as $question){
            $choices = Choice::where('question_id', $question -> id)->get();
            foreach($choices as $choice){
                $choice-> delete();
            }
            $question -> delete();
        }

        $quiz->delete();
        return response()->json("Quiz deleted successfully", 200);
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


    public function submitQuiz(Request $request){

        $data = json_decode($request->getContent(), true);

        $foundScore = Score::where([
            ["user_id", "=", auth()->user()->id],
            ["quiz_id", "=", $data["quiz_id"]]])
            ->get();

        if (count($foundScore)>0) {
            return response()->json(["error"=> 'You have already taken this quiz'],400);
        }

        $score = new Score();
        $totalEarning = 0;

        foreach($data['answers'] as $data_answer){
            $question = Question::find($data_answer['question_id']);

            if($question->answer==$data_answer['answer']){
                $totalEarning += $question->earnings;
            }
        }

        $score -> user_id = auth()->user()->id;
        $score -> quiz_id = $data['quiz_id'];
        $score -> score = $totalEarning;
        $score -> save();

        return $score;
    }
}
