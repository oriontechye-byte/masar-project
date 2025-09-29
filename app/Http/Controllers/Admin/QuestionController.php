<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntelligenceType;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('intelligenceType')->orderBy('id')->paginate(20);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $intelligenceTypes = IntelligenceType::pluck('name', 'id');
        return view('admin.questions.create', compact('intelligenceTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'intelligence_type_id' => 'required|exists:intelligence_types,id',
        ]);

        Question::create($request->all());

        return redirect()->route('admin.questions.index')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    public function edit(Question $question)
    {
        $intelligenceTypes = IntelligenceType::pluck('name', 'id');
        return view('admin.questions.edit', compact('question', 'intelligenceTypes'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'intelligence_type_id' => 'required|exists:intelligence_types,id',
        ]);

        $question->update($request->all());

        return redirect()->route('admin.questions.index')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'تم حذف السؤال بنجاح.');
    }
}
