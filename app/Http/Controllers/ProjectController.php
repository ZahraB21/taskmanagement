<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller
{
    // Getting all projects
   public function index(){
        // $projects = Project::where('is_completed', false)
        // ->orderBy('created_at', 'desc')
        // ->withCount(['tasks' => function ($query) {
        // $query->where('is_completed', false);
        // }])
        // ->get();

        // return $projects->toJson();
        // $project = Project::all()->withCount(['tasks' => function($query){
        //     $query->where('is_completed',false);
        // }]);

        $project = Project::all();
        return $project;
   }

   // Saving a new project
   public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $project = Project::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description']
        ]);

        return $response->json('Project created');
   }

   // Displaying a specific project
   public function show($id){
        $project = Project::with(['tasks' => function ($query){
            $query->where('is_completed', false);
        }])->find($id);

        return $project->toJson();
   }

   // Updating a project
   public function markAsCompleted(Project $project){
       $project->is_completed = true;
       $project->update();
       
       return response()->json('Project updated successfully');
   }
}
