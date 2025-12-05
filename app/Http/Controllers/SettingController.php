<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function modes(): View
    {
        return view('settings.modes');
    }

    public function languages(): View
    {
        return view('settings.languages');
    }
}
