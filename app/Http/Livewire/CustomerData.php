<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Offer;
use Livewire\Component;

class CustomerData extends Component
{
    public $open = false;
    public $dni, $name, $lastName, $birthDate, $address, $email;
    public $hasQuotation = false;
    public $message = '';
    protected $rules = [
        'dni' => 'required',
        'name' => 'required',
        'lastName' => 'required',
        'birthDate' => 'required',
        'address' => 'required',
        'email' => 'required',
    ];
    public function render()
    {
        return view('livewire.customer-data');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        $customer = Customer::where('dni', $this->dni)->first();
        if ($customer) {
            if ($customer->hasValidQuotation()) {
                $this->hasQuotation = true;
                $this->message = 'El cliente posee una cotización válida';
                // $this->emitTo($this, 'render');
            }
            // $this->emit('alert', 'El cliente se encuentra registrado');
        } else {
            $customer = Customer::create([
                'dni' => $this->dni,
                'name' => $this->name,
                'lastName' => $this->lastName,
                'birthDate' => $this->birthDate,
                'address' => $this->address,
                'email' => $this->email,
            ]);
            session(['new_customer_id' => $customer->id]);
            redirect()->to('generarCotizacionVendedor');
        }
        $this->reset(['open', 'dni', 'name', 'lastName', 'birthDate', 'address', 'email']);
        // $this->emit('render'); //Emite a todos los componentes que oyen el evento render
        // $this->emitTo('show-post', 'render');
        // $this->emit('alert', 'El cliente se encuentra registrado');
    }
}
