<?php

namespace App\Http\Livewire;

use App\Models\Offer;
use Livewire\Component;

class ShowOffers extends Component
{
    public $titulo;
    public $search;
    public $sort = "updated_at";
    public $direction = "desc";

    protected $listeners = ['render' => 'render']; //Si el evento que escucha y la funcion que ejecuta tienen el mismo nombre, se puede poner solo 1 vez el nombre. Por ejemplo: ['render']

    public function mount($title)
    {
        $this->titulo = $title;
    }

    public function render()
    {
        $offers = Offer::where('discount', 'LIKE', '%'.$this->search.'%')
        ->orWhere('startDate', 'LIKE', '%'.$this->search.'%')
        ->orWhere('endDate', 'LIKE', '%'.$this->search.'%')
        ->orderBy($this->sort, $this->direction)
        ->get();
        return view('livewire.show-offers', compact('offers'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) {
            if ($this->direction == 'desc') {
                $this->direction = 'asc';
            } else {
                $this->direction = 'desc';
            }
            
        } else {
            $this->direction = 'asc';
            $this->sort = $sort;
        }
    }

}
