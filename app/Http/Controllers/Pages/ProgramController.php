<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Program;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::latest()->get();
        return view('pages.program', compact('programs'));
    }
}
