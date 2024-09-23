<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class Projects extends Controller
{

    public function __invoke(Request $request)
    {
        $projects = Project::all();
        return view('projects',compact('projects'));
    }
}
