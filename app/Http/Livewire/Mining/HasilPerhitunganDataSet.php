<?php

namespace App\Http\Livewire\Mining;

use App\Http\Livewire\CoreComponent;

class HasilPerhitunganDataSet extends CoreComponent
{
    public $data = [];
    public $jenis_kelamin = 'Laki-Laki';
    public function mount()
    {
        // $this->data = $this->perhitunganDataSet(true, $this->jenis_kelamin);
        // dd($this->data);
    }

    public function render()
    {
        $this->data = $this->perhitunganDataSet(true, $this->jenis_kelamin);
        return view('livewire.mining.hasil-perhitungan-data-set');
    }
}
