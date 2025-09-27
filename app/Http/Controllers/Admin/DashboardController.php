<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية مع الإحصائيات.
     */
    public function index()
    {
        $stats = [
            'students_count' => DB::table('students')->count(),
            // يمكن إضافة إحصائيات أخرى هنا مستقبلاً
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

