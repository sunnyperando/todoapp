<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;
        $user = auth()->user();

        // TASKS
        $tasks = Task::where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->where(function ($qq) use ($user) {
                    $qq->where('created_by', $user->id)
                       ->orWhere('assigned_to', $user->id);
                });
            })
            ->get();

        // PROJECTS
        $projects = Project::where('name', 'like', "%{$query}%")
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->where('created_by', $user->id);
            })
            ->get();

        return view('admin.search.index', compact('tasks', 'projects', 'query'));
    }
}