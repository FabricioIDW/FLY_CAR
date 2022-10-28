<?php

namespace App\Http\Livewire;

use App\Models\Offer;
use Livewire\Component;

class CreateOffer extends Component
{
    public $open = false;
    public $discount, $startDate, $endDate;
    protected $rules = [
        'discount' => 'required',
        'startDate' => 'required',
        'endDate' => 'required',
    ];
    public function render()
    {
        return view('livewire.create-offer');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        Offer::create([
            'discount' => $this->discount,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);
        $this->reset(['open', 'discount', 'startDate', 'endDate']);
        // $this->emit('render'); //Emite a todos los componentes que oyen el evento render
        $this->emitTo('show-post', 'render');
        $this->emit('alert', 'La oferta se creo correctamente.');
    }
}
