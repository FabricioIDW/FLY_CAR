<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Quotation;
use Livewire\Component;
use Livewire\WithPagination;

class QuotationSearch extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = "id";
    public $direction = "desc";

    public function updatingSearch()
    {
        return $this->resetPage();
    }
    public function render()
    {
        $customer = Customer::where('dni', 'LIKE', '%' . $this->search . '%')->first();
        $customer_id = $customer ? $customer->id : '';
        $input = $this->search;
        $quotations = Quotation::where('valid', 1)
            ->where(function ($query) use ($input, $customer_id) {
                $query->where('customer_id', 'LIKE', '%' . $customer_id . '%')
                    ->orWhere('id', 'LIKE', '%' . $input . '%')
                    ->orWhere('dateTimeGenerated', 'LIKE', '%' . $input . '%')
                    ->orWhere('dateTimeExpiration', 'LIKE', '%' . $input . '%')
                    ->orWhere('finalAmount', 'LIKE', '%' . $input . '%');
            })
            ->orderBy($this->sort, $this->direction)
            ->get();
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
