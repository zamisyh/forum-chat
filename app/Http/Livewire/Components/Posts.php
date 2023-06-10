<?php

namespace App\Http\Livewire\Components;

use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Topic;
use App\Models\Tag;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Route;


class Posts extends Component
{
    use LivewireAlert, WithPagination;
    protected $paginationTheme = 'tailwind';


    protected $listeners = [
        'loginSuccess',
        'logoutSuccess',
        'updateTag',
        'confirmed', 'cancelled'
    ];

    public $title, $slug, $description, $topic_id, $tag_id, $tag_name;
    public $data_tag, $data_topic;
    public $rows = 5, $question_id, $sortTab = 'desc', $countPost = 0;
    public $currentRoute, $currentRouteParams, $profileId;

    public function mount()
    {
        $this->tagData();
        $this->counterPost();
        $this->checkingRoute();
        $this->checkingData();
    }


    public function render()
    {
        $data = null;

        if ($this->currentRoute === 'client.home') {
            $data['data']['data_question'] = Question::with('topic')
                ->when($this->sortTab === 'views', function($q) {
                    $q->popularAllTime();
                }, function($q) {
                    $q->orderBy('created_at', $this->sortTab);
                })->paginate($this->rows);


        }else if($this->currentRoute === 'client.home.topic'){
            $data['data']['data_question'] = Question::where('topic_id', $this->topic_id->id)
            ->when($this->sortTab === 'views', function($q){
                $q->popularAllTime();
            }, function($q){
                $q->orderBy('created_at', $this->sortTab);
            })->paginate($this->rows);

            $data['data']['count_question'] = count($data['data']['data_question']);
        }else if($this->currentRoute === 'client.home.tag'){
            $data['data']['data_question'] = Question::whereHas('tags', function($q){
                $q->whereIn('tag_id', $this->tag_id);
            })->when($this->sortTab === 'views', function($q) {
                $q->popularAllTime();
            }, function($q){
                $q->orderBy('created_at', $this->sortTab);
            })->paginate($this->rows);

            $data['data']['count_question'] = count($data['data']['data_question']);
        }else if($this->currentRoute === 'client.home.profile'){
            $data['data']['data_question'] = Question::where('user_id', $this->profileId)
            ->when($this->sortTab === 'views', function($q){
                $q->popularAllTime();
            }, function($q){
                $q->orderBy('created_at', $this->sortTab);
            })->paginate($this->rows);

            $data['data']['count_question'] = count($data['data']['data_question']);
        }
        return view('livewire.components.posts', $data)->extends('layouts.app')->section('content');
    }

    public function loginSuccess() { Auth::check(); }
    public function logoutSuccess() { Auth::check(); }

    public function saveQuestion()
    {
        $this->validate([
            'title' => 'required|unique:questions,title',
            'description' => 'required',
            'topic_id' => 'required',
        ]);

        try {
            $question = Question::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'description' => $this->description,
                'topic_id' => $this->topic_id,
                'user_id' => Auth::user()->id
            ]);

            $question->tags()->attach($this->tag_id);

            $this->alert('success', 'Succesfully create question', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            // $this->reset();
            $this->counterPost();



        } catch (\Exception $e) {
           dd($e->getMessage());
        }

    }

    public function saveTag()
    {
        $this->validate([
            'tag_name' => 'required|unique:tags,title'
        ]);

        try {
            Tag::create([
                'title' => ucwords(strtolower($this->tag_name)),
                'slug' => Str::slug($this->tag_name)
            ]);

            $this->alert('success', 'Succesfully create tags', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);

            $this->reset(['tag_name']);

            $this->emit('updateTag');
            $this->counterPost();

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function tagData() { $this->data_tag = Tag::orderBy('created_at', 'DESC')->get(); }
    public function updateTag() { $this->tagData(); }

    public function delete($id)
    {
        $this->confirm('Are you sure delete this question?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'No',
            'onConfirmed' => 'confirmed',
            'onCancelled' => 'cancelled'
        ]);

        $this->question_id = $id;
    }

    public function confirmed()
    {

        $data = Question::findOrFail($this->question_id);
        $data->tags()->detach();
        $data->delete();

        $this->alert(
            'success',
            'Successfully delete question'
        );

        $this->counterPost();
    }

    public function sortTabCheck($value)
    {
        $this->sortTab = $value;
    }

    public function counterPost()
    {
        $this->countPost = Question::count();
    }


    public function checkingRoute()
    {
        $this->currentRoute = Route::currentRouteName();
        if ($this->currentRoute === 'client.home.topic') {
            $this->topic_id = Topic::where('slug', Route::getCurrentRoute()->parameters['slug'])->first();
            $this->title = ucwords(strtolower(Str::of(Route::getCurrentRoute()->parameters['slug'])->replace('-', ' ')));

        }else if ($this->currentRoute === 'client.home.tag') {
            $this->tag_id = Tag::where('slug', Route::getCurrentRoute()->parameters['slug'])->pluck('id')->toArray();
            $this->title = ucwords(strtolower(Str::of(Route::getCurrentRoute()->parameters['slug'])->replace('-', ' ')));

        }else if ($this->currentRoute === 'client.home.profile'){
            $this->profileId = Route::getCurrentRoute()->parameters['id'];
        }
    }


    public function checkingData()
    {
        $this->data_topic = Topic::orderBy('created_at', 'DESC')->get();
    }


}
