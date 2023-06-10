<?php

namespace App\Http\Livewire\Topic;

use App\Models\Question;
use Livewire\Component;
use App\Models\Topic;

class Home extends Component
{
    // public $topic_id, $countPost = 0;
    // public $rows = 5, $sortTab = 'desc';

    // public function mount($slug)
    // {
    //     $this->topic_id = Topic::where('slug', $slug)->first();
    //     $this->countPost = Question::where('topic_id', $this->topic_id->id)->count();
    // }

    public function render()
    {
        // $data = null;
        // $data['data']['data_question'] = Question::where('topic_id', $this->topic_id->id)->orderBy('created_at', $this->sortTab)->paginate($this->rows);

        return view('livewire.topic.home')->extends('layouts.app')->section('content');
    }

    // public function sortTabCheck($value)
    // {
    //     $this->sortTab = $value;
    // }
}
