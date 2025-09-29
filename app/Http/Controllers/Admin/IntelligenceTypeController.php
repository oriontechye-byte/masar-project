<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntelligenceType; // Using the IntelligenceType Model
use Illuminate\Http\Request;

class IntelligenceTypeController extends Controller
{
    /**
     * Display a listing of all intelligence types.
     */
    public function index()
    {
        $types = IntelligenceType::orderBy('id')->get();
        return view('admin.intelligence_types.index', compact('types'));
    }

    /**
     * Show the form for editing a specific intelligence type.
     */
    public function edit(IntelligenceType $type)
    {
        return view('admin.intelligence_types.edit', compact('type'));
    }

    /**
     * Update the specified intelligence type in storage.
     */
    public function update(Request $request, IntelligenceType $type)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'careers' => 'required|string|max:500',
        ], [
            'description.required' => 'حقل الوصف مطلوب.',
            'careers.required' => 'حقل التخصصات المقترحة مطلوب.',
        ]);

        $type->update([
            'description' => $request->description,
            'careers' => $request->careers,
        ]);

        return redirect()->route('admin.types.index')->with('success', 'تم تحديث البيانات بنجاح.');
    }
}
