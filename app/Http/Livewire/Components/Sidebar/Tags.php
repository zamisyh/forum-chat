<?php

namespace App\Http\Livewire\Components\Sidebar;

use Livewire\Component;
use App\Models\Tag;

class Tags extends Component
{
    protected $listeners = [
        'updateTag'
    ];

    public $data_tag;

    public function mount()
    {
        $this->getDataTag();
    }

    public function render()
    {
        return view('livewire.components.sidebar.tags');
    }

    public function getDataTag() { $this->data_tag = Tag::orderBy('created_at', 'DESC')->get(); }
    public function updateTag() { $this->getDataTag(); }

}
