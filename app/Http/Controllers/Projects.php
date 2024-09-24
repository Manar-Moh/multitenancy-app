<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Stancl\Tenancy\Facades\Tenancy;

class Projects extends Controller
{

    public function __invoke(Request $request)
    {
        $projects = Project::all();
        return view('projects',compact('projects'));
    }
}
