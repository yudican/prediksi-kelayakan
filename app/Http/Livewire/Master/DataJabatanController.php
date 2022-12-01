<?php

namespace App\Http\Livewire\Master;

use App\Models\DataJabatan;
use Livewire\Component;


class DataJabatanController extends Component
{
    
    public $tbl_data_jabatan_id;
    public $nama_jabatan;
    
   

    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataJabatanById', 'getDataJabatanId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.master.tbl-data-jabatan', [
            'items' => DataJabatan::all()
        ]);
    }

    public function store()
    {
        $this->_validate();
        
        $data = ['nama_jabatan'  => $this->nama_jabatan];

        DataJabatan::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = ['nama_jabatan'  => $this->nama_jabatan];
        $row = DataJabatan::find($this->tbl_data_jabatan_id);

        

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        DataJabatan::find($this->tbl_data_jabatan_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'nama_jabatan'  => 'required'
        ];

        return $this->validate($rule);
    }

    public function getDataDataJabatanById($tbl_data_jabatan_id)
    {
        $this->_reset();
        $row = DataJabatan::find($tbl_data_jabatan_id);
        $this->tbl_data_jabatan_id = $row->id;
        $this->nama_jabatan = $row->nama_jabatan;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataJabatanId($tbl_data_jabatan_id)
    {
        $row = DataJabatan::find($tbl_data_jabatan_id);
        $this->tbl_data_jabatan_id = $row->id;
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
        $this->tbl_data_jabatan_id = null;
        $this->nama_jabatan = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
