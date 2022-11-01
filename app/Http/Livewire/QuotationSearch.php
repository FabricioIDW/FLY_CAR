<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Vehicle;
use Livewire\Component;
use Livewire\WithPagination;

class QuotationSearch extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;

    public function updatingSearch(){
        return $this->resetPage();
    }
    public function render()
    {
        $quotations = Quotation::where('id', 'like','%'.$this->search.'%')->paginate();
        return view('livewire.quotation-search', compact('quotations'));
    }
    public function misCotizaciones(Customer $customer)
    {
        $quotations = Quotation::where('customer_id', $customer->id)->paginate();
        return view('livewire.quotation-search', compact('quotations'));
    }
}
