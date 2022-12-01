<?php

namespace App\Http\Livewire\Mining;

use App\Http\Livewire\CoreComponent;
use App\Models\DataNasabah;

class PengujianDataSet extends CoreComponent
{
    public $data = [];
    public $no = 1;
    public function mount()
    {
        $datas = [];
        $data = DataNasabah::with(['dataLatih.attributeNilai'])->get();
        $data_latih  = [];
        $c45 = $this->getData();
        $tree = $c45->buildTree();
        foreach ($data as $key => $item) {
            foreach ($item->dataLatih as $latih) {
                $data_latih[$latih->attributeNilai->attribute->nama_atribut] = $latih->attributeNilai->nilai_atribut;
            }
            $datas[$key]['nama'] = $item->nama;
            $datas[$key]['data_latih'] = $item->dataLatih;
            $datas[$key]['hasil_uji'] = $tree->classify($data_latih);
        }
        $this->data = $datas;
    }

    public function render()
    {
        return view('livewire.mining.pengujian-data-set');
    }
}
