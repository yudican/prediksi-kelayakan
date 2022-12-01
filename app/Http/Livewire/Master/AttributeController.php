<?php

namespace App\Http\Livewire\Master;

use App\Models\Attribute;
use Livewire\Component;


class AttributeController extends Component
{

    public $tbl_attributes_id;
    public $nama_atribut;



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataAttributeById', 'getAttributeId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.tbl-attributes', [
            'items' => Attribute::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = ['nama_atribut'  => $this->nama_atribut, 'status' => 0];

        Attribute::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['nama_atribut'  => $this->nama_atribut];
        $row = Attribute::find($this->tbl_attributes_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        Attribute::find($this->tbl_attributes_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'nama_atribut'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataAttributeById($tbl_attributes_id)
    {
        $this->_reset();
        $row = Attribute::find($tbl_attributes_id);
        $this->tbl_attributes_id = $row->id;
        $this->nama_atribut = $row->nama_atribut;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getAttributeId($tbl_attributes_id)
    {
        $row = Attribute::find($tbl_attributes_id);
        $this->tbl_attributes_id = $row->id;
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
        $this->tbl_attributes_id = null;
        $this->nama_atribut = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
