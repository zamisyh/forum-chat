<?php

namespace App\Http\Livewire\Components\Sidebar;

use Livewire\Component;
use App\Models\Topic;

class Topics extends Component
{

    public $data_topic;

    public function mount()
    {
        $this->data_topic = Topic::all();
    }

    public function render()
    {
        return view('livewire.components.sidebar.topics')->extends('layouts.app')->section('content');
    }
}
