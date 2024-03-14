<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ShowProducts extends Component
{
    use WithPagination;

    public $search;
    public $visibleColumns = ['name', 'category', 'status', 'price']; // Inicializa las columnas visibles

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleColumn($column)
    {
        if (in_array($column, $this->visibleColumns)) {
            unset($this->visibleColumns[array_search($column, $this->visibleColumns)]);
        } else {
            $this->visibleColumns[] = $column;
        }
        $this->visibleColumns = array_values($this->visibleColumns); // Re-index the array
    }

    public function render()
    {
        $products = Product::where('name', 'LIKE', "%{$this->search}%")->paginate(10);

        return view('livewire.admin.show-products', [
            'products' => $products,
            'visibleColumns' => $this->visibleColumns
        ])->layout('layouts.admin');
    }
}
