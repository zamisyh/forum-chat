<?php

namespace App\Http\Livewire\Tags;

use Livewire\Component;
use App\Models\Question;
use App\Models\Tag;

class Home extends Component
{

    public $tag_id, $countPost = 0;
    public $rows = 5, $sortTab = 'desc', $title;

    // public function mount($slug)
    // {
    //     $this->tag_id = Tag::where('slug', $slug)->pluck('id')->toArray();
    //     $this->title = Tag::where('slug', $slug)->pluck('title')->first();

    // }

    public function render()
    {
        // $data = null;

        // $data['data']['data_tag'] = Question::whereHas('tags', function($q){
        //     $q->whereIn('tag_id', $this->tag_id);
        // })->orderBy('created_at', $this->sortTab)->paginate($this->rows);

        // $this->countPost = count($data['data']['data_tag']);

        return view('livewire.tags.home')->extends('layouts.app')->section('content');
    }

    // public function sortTabCheck($value)
    // {
    //     $this->sortTab = $value;
    // }
}
