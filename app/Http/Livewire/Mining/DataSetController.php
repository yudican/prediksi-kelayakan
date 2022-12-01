<?php

namespace App\Http\Livewire\Mining;

use App\Models\Attribute;
use App\Models\DataKaryawan;
use App\Models\DataLatih;
use App\Models\DataSet;
use App\Models\DataSetDetail;
use Carbon\Carbon;
use Livewire\Component;


class DataSetController extends Component
{

    public $data_set_id;
    public $kode;
    public $attribute_nilai_id = [];



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataSetById', 'getDataSetId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.mining.tbl-data-set', [
            'items' => DataSet::all(),
            'attributes' => Attribute::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        $data_set = DataSet::create(['kode' => 'SET-' . rand(123, 534) . '-' . rand(534, 796)]);
        if (is_array($this->attribute_nilai_id)) {
            $data_to_store = [];
            foreach ($this->attribute_nilai_id as $key => $value) {
                $data_to_store[] = [
                    'data_set_id' => $data_set->id,
                    'attribute_nilai_id' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            DataSetDetail::insert($data_to_store);
        }

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data_set = DataSet::find($this->data_set_id);
        $data_set->dataSetDetail()->delete();
        // update data setingan
        if (is_array($this->attribute_nilai_id)) {
            $data_to_store = [];
            foreach ($this->attribute_nilai_id as $key => $value) {
                $data_to_store[] = [
                    'data_set_id' => $data_set->id,
                    'attribute_nilai_id' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            DataSetDetail::insert($data_to_store);
        }

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        $data_set = DataSet::find($this->data_set_id);
        $data_set->delete();
        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [];
        $attributes = Attribute::whereStatus(0)->get();

        foreach ($attributes as $key => $attribute) {
            $rule['attribute_nilai_id.' . $key] = 'required';
        }

        return $this->validate($rule);
    }

    public function getDataDataSetById($data_set_id)
    {
        $this->_reset();
        $row = DataSet::find($data_set_id);
        $this->data_set_id = $row->id;
        $this->kode = $row->kode;
        $this->attribute_nilai_id = DataSetDetail::where('data_set_id', $row->id)->pluck('attribute_nilai_id')->toArray();
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataSetId($data_set_id)
    {
        $row = DataSet::find($data_set_id);
        $this->data_set_id = $row->id;
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
        $this->data_set_id = null;
        $this->kode = null;
        $this->attribute_nilai_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
