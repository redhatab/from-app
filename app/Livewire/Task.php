<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Task as ModelsTask;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Task extends Component
{
    public $id = 0,
        $title = null,
        $description = null,
        $due_date = '',
        $time = '',
        $category_id = 0,
        $completed = false;

    public $isEntryModalVisible = false, $isEdit = false;

    public function render()
    {
        $categories = Category::get();

        $tasks = ModelsTask::join('categories', 'tasks.category_id', '=', 'categories.id')
            ->select('tasks.id', 'tasks.title', 'tasks.description', 'tasks.due_date', 'tasks.time', 'categories.name', 'tasks.completed')
            ->where('tasks.user_id', '=', Auth::user()->id)
            ->orderBy('tasks.due_date')
            ->paginate(25);

        return view('livewire.task', ['categories' => $categories, 'tasks' => $tasks]);
    }

    public function setEntryModalVisible($isEdit, $id = null)
    {
        $this->resetFields();
        $this->isEdit = $isEdit;

        if ($this->isEdit) {
            $this->edit($id);
        }

        $this->isEntryModalVisible = !$this->isEntryModalVisible;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:191',
            'due_date' => 'required',
            'time' => 'required',
            'category_id' => 'required|numeric|min:1'
        ]);

        ModelsTask::create([
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => Carbon::parse($this->due_date)->format('Y-m-d'),
            'time' => $this->time,
            'category_id' => $this->category_id,
            'completed' => $this->completed,
            'user_id' => Auth::user()->id
        ]);

        $this->setEntryModalVisible(false);

        session()->flash('msg', 'Запись успешно создана');
    }

    public function edit($id)
    {
        $this->id = $id;

        $task = ModelsTask::findOrFail($this->id);
        $this->title = $task->title;
        $this->description = $task->description;
        $this->due_date = Carbon::parse($task->due_date)->format('d.m.Y');
        $this->time = $task->time;
        $this->category_id = $task->category_id;
        $this->completed = ($task->completed) ? true : false;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:191',
            'due_date' => 'required',
            'time' => 'required',
            'category_id' => 'required|numeric|min:1'
        ]);

        $task = ModelsTask::findOrFail($this->id);
        $task->title = $this->title;
        $task->description = $this->description;
        $task->due_date = Carbon::parse($this->due_date)->format('Y-m-d');
        $task->time = $this->time;
        $task->category_id = $this->category_id;
        $task->completed = $this->completed;
        $task->user_id = Auth::user()->id;
        $task->update();

        $this->setEntryModalVisible(false);

        session()->flash('msg', 'Запись успешно обновлена');
    }

    public function destroy($id)
    {
        $task = ModelsTask::findOrFail($id);
        $task->delete();

        session()->flash('msg', 'Запись успешно удалена');
    }

    public function resetFields()
    {
        $this->id = 0;
        $this->title = null;
        $this->description = null;
        $this->due_date = '';
        $this->time = '';
        $this->category_id = 0;
        $this->completed = false;

        $this->resetValidation();
        $this->resetErrorBag();
    }
}
