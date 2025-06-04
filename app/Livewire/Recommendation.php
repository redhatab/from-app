<?php

namespace App\Livewire;

use App\Http\Controllers\GigaChatAPIController;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Recommendation extends Component
{
    public $responseToChat = null;

    public function render()
    {
        return view('livewire.recommendation');
    }

    public function getRecommendations()
    {
        $this->askGigaChat($this->query());
    }

    protected function query(): string
    {
        $query = 'Проанализируй мои задачи и сроки их исполнения и порекомендуй, как их можно оптимизировать: ';

        $tasks = Task::select('title', 'due_date', 'time')
            ->where('user_id', '=', Auth::user()->id)
            ->get();

        foreach ($tasks as $key => $value) {
            $query .= 'Задача: ' . $value->title . '; Срок исполнения: ' . $value->due_date . ' ' . $value->time;
        }
        
        return $query;
    }

    public function askGigaChat($query)
    {
        $chat = new GigaChatAPIController();
        $this->responseToChat = $chat->ask($query);
    }
}
