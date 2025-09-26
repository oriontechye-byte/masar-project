<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function showTest()
    {
        $questions = DB::table('questions')->get();
        return view('test', ['questions' => $questions]);
    }

    public function calculateResult(Request $request)
    {
        $answers = $request->input('answers');
        $studentId = $request->input('student_id'); // Get the student's ID from the hidden field
        $questions = DB::table('questions')->get()->keyBy('id');
        $scores = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0];

        foreach ($answers as $question_id => $value) {
            $question = $questions[$question_id];
            $intelligence_type_id = $question->intelligence_type_id;
            $scores[$intelligence_type_id] += $value;
        }

        // Save the results to the new table
        DB::table('test_results')->insert([
            'student_id' => $studentId,
            'score_social' => $scores[1],
            'score_visual' => $scores[2],
            'score_intrapersonal' => $scores[3],
            'score_kinesthetic' => $scores[4],
            'score_logical' => $scores[5],
            'score_naturalist' => $scores[6],
            'score_linguistic' => $scores[7],
            'score_musical' => $scores[8],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $intelligenceTypes = DB::table('intelligence_types')->get()->keyBy('id');
        arsort($scores);

        return view('results', ['scores' => $scores, 'intelligenceTypes' => $intelligenceTypes]);
    }
}