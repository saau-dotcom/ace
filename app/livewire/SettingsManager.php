<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\EquipmentProduct;

#[Title('Settings - Solar ACE')]
class SettingsManager extends Component
{
    public $type = 'Panel';
    public $brand = '';
    public $model_name = '';

    protected $rules = [
        'type' => 'required|in:Panel,Battery,Inverter',
        'brand' => 'required|string|max:255',
    ];

    public function addProduct()
    {
        $this->validate();

        EquipmentProduct::create([
            'type' => $this->type,
            'brand' => $this->brand,
            'model_name' => $this->model_name,
            'is_active' => true,
        ]);

        $this->reset(['brand', 'model_name']);
        session()->flash('message', 'Product added successfully.');
    }

    public function deleteProduct($id)
    {
        EquipmentProduct::findOrFail($id)->delete();
        session()->flash('message', 'Product deleted successfully.');
    }

    public function render()
    {
        return view('livewire.settings-manager', [
            'panels' => EquipmentProduct::where('type', 'Panel')->get(),
            'batteries' => EquipmentProduct::where('type', 'Battery')->get(),
            'inverters' => EquipmentProduct::where('type', 'Inverter')->get(),
        ]);
    }
}
