<?php

namespace App\Http\Livewire\Admin;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class BrandComponent extends Component
{

    use WithPagination;

    public $brands, $brand;

    public $perPage = 10;

    public $createForm=[
        'name' => null
    ];

    public $editForm=[
        'open' => false,
        'name' => null
    ];

    public $rules = [
        'createForm.name' => 'required'
    ];

    protected $validationAttributes = [
        'createForm.name' => 'nombre',
        'editForm.name' => 'nombre'
    ];

    protected $listeners = ['delete'];

    public function mount()
    {
        $this->getBrands();
    }

    public function getBrands()
    {
        $this->brands = Brand::all();
    }

    public function save()
    {
        $this->validate();

        Brand::create($this->createForm);

        $this->reset('createForm');

        $this->getBrands();
    }

    public function edit(Brand $brand)
    {
        $this->brand = $brand;

        $this->editForm['open'] = true;
        $this->editForm['name'] = $brand->name;
    }

    public function update()
    {
        $this->validate([
            'editForm.name' => 'required'
        ]);

        $this->brand->update($this->editForm);
        $this->reset('editForm');

        $this->getBrands();
    }

    public function delete(Brand $brand)
    {
        $brand->delete();
        $this->getBrands();
    }

    public function render()
    {

        $brands = Brand::paginate($this->perPage);


        return view('livewire.admin.brand-component', compact('brands'))->layout('layouts.admin');
    }
}
