<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Offer;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

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
        $customer = Customer::where('dni', $this->dni)->where('email', $this->email)->first();
        if ($customer) {
            if ($customer->hasValidQuotation()) {
                if ($customer->getQuotation()->reserve) {
                    $this->emit('errorAlert', 'El cliente posee una cotización con una reserva activa.');
                } else {
                    // TO DO aumentar stock de los accesorios
                    $customer->getQuotation()->setVehicles('availabled');
                    $customer->disableQuotation();
                    session(['customer_id' => $customer->id]);
                    redirect()->to('generarCotizacionVendedor');
                }
            }
        } else {
            $this->validate([
                'dni' => 'unique:customers',
                'email' => 'unique:customers',
            ]);
            $customer = Customer::create([
                'dni' => $this->dni,
                'name' => $this->name,
                'lastName' => $this->lastName,
                'birthDate' => $this->birthDate,
                'address' => $this->address,
                'email' => $this->email,
            ]);
            session(['customer_id' => $customer->id]);
            redirect()->to('generarCotizacionVendedor');
        }
        $this->reset(['open', 'dni', 'name', 'lastName', 'birthDate', 'address', 'email']);
    }
}
