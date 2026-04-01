<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class DashboardController extends Controller
{

    public function index()
    {
        $userId = auth()->id();

        // FIRST define totalTasks
        $totalTasks = Task::where('created_by', $userId)->count();

        // THEN use it
        $completedTasks = Task::where('created_by', $userId)
            ->where('status', 'done')
            ->count();

        $progress = $totalTasks > 0 
            ? ($completedTasks / $totalTasks) * 100 
            : 0;

        $todayTasks = Task::where('created_by', $userId)
            ->whereDate('due_date', today())
            ->count();

        $overdueTasks = Task::where('created_by', $userId)
            ->where('due_date', '<', today())
            ->where('status', '!=', 'done')
            ->count();

        $upcomingTasks = Task::where('created_by', $userId)
            ->where('due_date', '>', today())
            ->count();

        $totalProjects = Project::where('created_by', $userId)->count();

        return view('dashboard', compact(
            'totalTasks',
            'todayTasks',
            'overdueTasks',
            'upcomingTasks',
            'totalProjects',
            'completedTasks',
            'progress'
        ));
    }
}
