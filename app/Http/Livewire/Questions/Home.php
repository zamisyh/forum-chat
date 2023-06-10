<?php

namespace App\Http\Livewire\Questions;

use App\Models\Question;
use Livewire\Component;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Symfony\Component\HttpKernel\DependencyInjection\RemoveEmptyControllerArgumentLocatorsPass;

class Home extends Component
{

    use LivewireAlert;

    protected $listeners = ['getCountVote'];

    public $data_question, $countVisit, $likeAction, $totalVote = 0;

    public function mount($id, $slug)
    {
        $this->data_question = Question::with('topic')->where([
            ['id', '=', $id],
            ['slug', '=', $slug]
        ])->popularAllTime()->first();

       $this->data_question->visit()->withSession();

    }

    public function render()
    {
        return view('livewire.questions.home')->extends('layouts.app')->section('content');
    }

    public function voteAction($postId)
    {
        if (is_null(Auth::user())) {
            $this->alert('info', 'To like this question you must login first', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'timerProgressBar' => true,
            ]);
        }

        $this->emit('getCountVote');

        // $vote = Vote::where([
        //     ['user_id', '=', Auth::user()->id],
        //     ['question_id', '=', $postId]
        // ])->first();

        // if (is_null($vote)) {
        //     $this->likeAction = false;
        // }else{
        //     Vote::create([
        //         'user_id' => Auth::user()->id,
        //         'question_id' => $postId
        //     ]);
        // }



    }

    public function getCountVote()
    {
        $this->totalVote += 1;
    }

}
