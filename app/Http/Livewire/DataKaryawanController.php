<?php

namespace App\Http\Livewire;

use App\Models\Attribute;
use App\Models\DataJabatan;
use App\Models\DataKaryawan;
use App\Models\DataLatih;
use App\Models\DataSet;
use Carbon\Carbon;
use Livewire\Component;


class DataKaryawanController extends Component
{

    public $tbl_data_karyawan_id;
    public $nik;
    public $nama;
    public $telepon;
    public $alamat;
    public $data_jabatan_id;
    public $eselon;
    public $gol;
    public $tmt;
    public $email;

    // data set
    public $attribute_nilai_id = [];



    public $route_name = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataKaryawanById', 'getDataKaryawanId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire..tbl-data-karyawan', [
            'items' => DataKaryawan::all(),
            'jabatans' => DataJabatan::all(),
            'attributes' => Attribute::where('status', 0)->get()
        ]);
    }

    public function store()
    {
        $this->_validate();
        try {
            $data = [
                'nik'  => $this->nik,
                'nama'  => $this->nama,
                'telepon'  => $this->telepon,
                // 'alamat'  => $this->alamat,
                'data_jabatan_id'  => $this->data_jabatan_id,
                'eselon'  => $this->eselon,
                'gol'  => $this->gol,
                'tmt'  => $this->tmt,
                'email'  => $this->email,
            ];
            $karyawan = DataKaryawan::create($data);
            // simpan data setingan
            if (is_array($this->attribute_nilai_id)) {
                $data_to_store = [];
                foreach ($this->attribute_nilai_id as $key => $value) {
                    $data_to_store[] = [
                        'data_karyawan_id' => $karyawan->id,
                        'attribute_nilai_id' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                DataLatih::insert($data_to_store);
            }

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
        } catch (\Throwable $th) {
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Disimpan']);
        }
    }

    public function update()
    {
        $this->_validate();
        try {
            $data = [
                'nik'  => $this->nik,
                'nama'  => $this->nama,
                'telepon'  => $this->telepon,
                // 'alamat'  => $this->alamat,
                'data_jabatan_id'  => $this->data_jabatan_id,
                'eselon'  => $this->eselon,
                'gol'  => $this->gol,
                'tmt'  => $this->tmt,
                'email'  => $this->email,
            ];
            $row = DataKaryawan::find($this->tbl_data_karyawan_id);

            $row->DataLatih()->delete();
            // update data setingan
            if (is_array($this->attribute_nilai_id)) {
                $data_to_store = [];
                foreach ($this->attribute_nilai_id as $key => $value) {
                    $data_to_store[] = [
                        'data_karyawan_id' => $row->id,
                        'attribute_nilai_id' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
                DataLatih::insert($data_to_store);
            }


            $row->update($data);

            $this->_reset();
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            $this->_reset();
            return $this->emit('showAlertError', ['msg' => 'Data Gagal Diupdate']);
        }
    }

    public function delete()
    {
        DataKaryawan::find($this->tbl_data_karyawan_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'nik'  => 'required',
            'nama'  => 'required',
            'telepon'  => 'required',
            'data_jabatan_id'  => 'required',
            'eselon'  => 'required',
            'gol'  => 'required',
            'tmt'  => 'required',
            'email'  => 'required|email',
        ];

        $attributes = Attribute::whereStatus(0)->get();

        foreach ($attributes as $key => $attribute) {
            $rule['attribute_nilai_id.' . $key] = 'required';
        }

        return $this->validate($rule);
    }

    public function getDataDataKaryawanById($tbl_data_karyawan_id)
    {
        $this->_reset();
        $row = DataKaryawan::find($tbl_data_karyawan_id);
        $this->tbl_data_karyawan_id = $row->id;
        $this->nik = $row->nik;
        $this->nama = $row->nama;
        $this->telepon = $row->telepon;
        $this->alamat = $row->alamat;
        $this->data_jabatan_id = $row->data_jabatan_id;
        $this->eselon = $row->eselon;
        $this->gol = $row->gol;
        $this->tmt = date('Y-m-d', strtotime($row->tmt));
        $this->email = $row->email;

        $this->attribute_nilai_id = $row->dataLatih()->pluck('attribute_nilai_id')->toArray();

        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getDataKaryawanId($tbl_data_karyawan_id)
    {
        $row = DataKaryawan::find($tbl_data_karyawan_id);
        $this->tbl_data_karyawan_id = $row->id;
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
        $this->tbl_data_karyawan_id = null;
        $this->attribute_nilai_id = [];
        $this->nik = null;
        $this->nama = null;
        $this->telepon = null;
        $this->alamat = null;
        $this->data_jabatan_id = null;
        $this->eselon = null;
        $this->gol = null;
        $this->tmt = null;
        $this->email = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
