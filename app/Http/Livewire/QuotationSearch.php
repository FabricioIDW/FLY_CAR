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
    public $sort = "updated_at";
    public $direction = "desc";

    public function updatingSearch(){
        return $this->resetPage();
    }
    public function render()
    {
        $allQuotations = Quotation::where('id', 'LIKE','%'.$this->search.'%')
        ->orWhere('dateTimeGenerated', 'LIKE', '%'.$this->search.'%')
        ->orWhere('dateTimeExpiration', 'LIKE', '%'.$this->search.'%')
        ->orWhere('finalAmount', 'LIKE', '%'.$this->search.'%')
        ->get();
        $quotations = [];
        foreach ($allQuotations as $quotation) {
            if ($quotation->valid) {
                $quotations[] = $quotation;
            }
        }
        return view('livewire.quotation-search', compact('quotations'));
    }
    public function misCotizaciones(Customer $customer)
    {
        $quotations = Quotation::where('customer_id', $customer->id)->paginate();
        return view('livewire.quotation-search', compact('quotations'));
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
