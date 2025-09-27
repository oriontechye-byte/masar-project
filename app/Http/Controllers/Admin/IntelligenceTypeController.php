<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntelligenceTypeController extends Controller
{
    /**
     * عرض قائمة بكل أنواع الذكاء.
     */
    public function index()
    {
        $types = DB::table('intelligence_types')->orderBy('id')->get();
        return view('admin.intelligence_types.index', compact('types'));
    }

    /**
     * عرض فورم تعديل نوع ذكاء معين.
     */
    public function edit($id)
    {
        $type = DB::table('intelligence_types')->find($id);
        if (!$type) {
            return redirect()->route('admin.types.index')->with('error', 'هذا النوع غير موجود.');
        }
        return view('admin.intelligence_types.edit', compact('type'));
    }

    /**
     * تحديث بيانات نوع الذكاء في قاعدة البيانات.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'careers' => 'required|string|max:500',
        ], [
            'description.required' => 'حقل الوصف مطلوب.',
            'careers.required' => 'حقل التخصصات المقترحة مطلوب.',
        ]);

        DB::table('intelligence_types')->where('id', $id)->update([
            'description' => $request->description,
            'careers' => $request->careers,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.types.index')->with('success', 'تم تحديث البيانات بنجاح.');
    }
}

