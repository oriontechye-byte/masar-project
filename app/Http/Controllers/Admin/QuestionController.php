<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of all questions.
     */
    public function index()
    {
        $questions = DB::table('questions')
            ->join('intelligence_types', 'questions.intelligence_type_id', '=', 'intelligence_types.id')
            ->select('questions.id', 'questions.text', 'intelligence_types.name as type_name')
            ->orderBy('questions.id')
            ->paginate(20);

        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create()
    {
        $intelligenceTypes = DB::table('intelligence_types')->pluck('name', 'id');
        return view('admin.questions.create', compact('intelligenceTypes'));
    }

    /**
     * Store a newly created question in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'intelligence_type_id' => 'required|exists:intelligence_types,id',
        ], [
            'text.required' => 'حقل نص السؤال مطلوب.',
            'intelligence_type_id.required' => 'يجب اختيار نوع الذكاء.',
        ]);

        DB::table('questions')->insert([
            'text' => $request->text,
            'intelligence_type_id' => $request->intelligence_type_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    /**
     * Show the form for editing an existing question.
     */
    public function edit($id)
    {
        $question = DB::table('questions')->find($id);
        if (!$question) {
            return redirect()->route('admin.questions.index')->with('error', 'السؤال غير موجود.');
        }

        $intelligenceTypes = DB::table('intelligence_types')->pluck('name', 'id');

        return view('admin.questions.edit', compact('question', 'intelligenceTypes'));
    }

    /**
     * Update an existing question in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'text' => 'required|string|max:500',
            'intelligence_type_id' => 'required|exists:intelligence_types,id',
        ], [
            'text.required' => 'حقل نص السؤال مطلوب.',
            'intelligence_type_id.required' => 'يجب اختيار نوع الذكاء.',
        ]);

        DB::table('questions')->where('id', $id)->update([
            'text' => $request->text,
            'intelligence_type_id' => $request->intelligence_type_id,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.questions.index')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    /**
     * Delete a question from the database.
     */
    public function destroy($id)
    {
        DB::table('questions')->where('id', $id)->delete();
        return redirect()->route('admin.questions.index')->with('success', 'تم حذف السؤال بنجاح.');
    }
}

