<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للمشروع.
     */
    public function showLandingPage()
    {
        return view('landing');
    }
}
