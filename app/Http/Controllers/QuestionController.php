<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getChoices($questions_id){
        return response()->json(Question::find($questions_id)->choices()->get(), 200);
    }
}
