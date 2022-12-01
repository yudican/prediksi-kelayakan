<?php

namespace App\Http\Livewire\Mining;

use App\Http\Livewire\CoreComponent;

class HasilPerhitunganDataSet extends CoreComponent
{
    public $data = [];
    public function mount()
    {
        $this->data = $this->perhitunganDataSet(true);
    }
    public function render()
    {
        return view('livewire.mining.hasil-perhitungan-data-set');
    }
}
