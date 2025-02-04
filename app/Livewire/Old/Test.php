<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Game;
use Livewire\Component;
use Livewire\WithPagination;

class Assets extends Component
{


    public function render()
    {
        return view('livewire.assets');
    }
}
