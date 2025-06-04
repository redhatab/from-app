<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $tasks = Task::join('categories', 'tasks.category_id', '=', 'categories.id')
            ->select('tasks.id', 'tasks.title', 'tasks.description', 'tasks.due_date', 'tasks.time', 'categories.name', 'tasks.completed')
            ->where('tasks.completed', '!=', true)
            ->where('tasks.user_id', '=', Auth::user()->id)
            ->orderBy('tasks.due_date')
            ->paginate(10);

        return view('livewire.dashboard', ['tasks' => $tasks]);
    }
}
