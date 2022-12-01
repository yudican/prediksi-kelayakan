<?php

namespace App\Http\Livewire\Mining;


use App\Http\Livewire\CoreComponent;


class KlasifikasiDataSet extends CoreComponent
{
    public $data = [];
    public function mount()
    {
        $this->data = $this->perhitunganDataSet();
    }


    public function render()
    {
        return view('livewire.mining.klasifikasi-data-set');
    }
}
