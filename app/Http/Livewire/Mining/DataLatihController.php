<?php

namespace App\Http\Livewire\Mining;

use App\Models\DataNasabah;
use App\Models\DataLatih;
use Livewire\Component;


class DataLatihController extends Component
{

    public $data_latih_id;
    public $data_nasabah_id;
    public $attribute_nilai_id;



    public $route_name = null;

    public $form_active = false;
    public $form = true;
    public $update_mode = false;
    public $modal = false;

    protected $listeners = ['getDataDataLatihById', 'getDataLatihId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.mining.tbl-data-latih', [
            'items' => DataNasabah::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'data_nasabah_id'  => $this->data_nasabah_id,
            'attribute_nilai_id'  => $this->attribute_nilai_id
        ];

        DataLatih::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'data_nasabah_id'  => $this->data_nasabah_id,
            'attribute_nilai_id'  => $this->attribute_nilai_id
        ];
        $row = DataLatih::find($this->data_latih_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataLatih::find($this->data_latih_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'data_nasabah_id'  => 'required',
            'attribute_nilai_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataLatihById($data_latih_id)
    {
        $this->_reset();
        $row = DataLatih::find($data_latih_id);
        $this->data_latih_id = $row->id;
        $this->data_nasabah_id = $row->data_nasabah_id;
        $this->attribute_nilai_id = $row->attribute_nilai_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataLatihId($data_latih_id)
    {
        $row = DataLatih::find($data_latih_id);
        $this->data_latih_id = $row->id;
    }

    public function toggleForm($form)
    {
        $this->_reset();
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->_reset();
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->data_latih_id = null;
        $this->data_nasabah_id = null;
        $this->attribute_nilai_id = null;
        $this->form = true;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = false;
    }
}
