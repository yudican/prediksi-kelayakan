<?php

namespace App\Http\Livewire\Master;

use App\Models\Attribute;
use App\Models\AttributeNilai;
use Livewire\Component;


class AttributeNilaiController extends Component
{

    public $tbl_attribute_nilai_id;
    public $nilai_atribut;
    public $attribute_id;



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataAttributeNilaiById', 'getAttributeNilaiId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.tbl-attribute-nilai', [
            'items' => AttributeNilai::all(),
            'attributes' => Attribute::all()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'nilai_atribut'  => $this->nilai_atribut,
            'attribute_id'  => $this->attribute_id
        ];

        AttributeNilai::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'nilai_atribut'  => $this->nilai_atribut,
            'attribute_id'  => $this->attribute_id
        ];
        $row = AttributeNilai::find($this->tbl_attribute_nilai_id);



        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        AttributeNilai::find($this->tbl_attribute_nilai_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'nilai_atribut'  => 'required',
            'attribute_id'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataAttributeNilaiById($tbl_attribute_nilai_id)
    {
        $this->_reset();
        $row = AttributeNilai::find($tbl_attribute_nilai_id);
        $this->tbl_attribute_nilai_id = $row->id;
        $this->nilai_atribut = $row->nilai_atribut;
        $this->attribute_id = $row->attribute_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getAttributeNilaiId($tbl_attribute_nilai_id)
    {
        $row = AttributeNilai::find($tbl_attribute_nilai_id);
        $this->tbl_attribute_nilai_id = $row->id;
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
        $this->tbl_attribute_nilai_id = null;
        $this->nilai_atribut = null;
        $this->attribute_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
