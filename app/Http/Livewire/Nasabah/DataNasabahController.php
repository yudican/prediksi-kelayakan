<?php

namespace App\Http\Livewire\Nasabah;

use App\Imports\DataNasabah as ImportsDataNasabah;
use App\Models\Attribute;
use App\Models\DataLatih;
use App\Models\DataNasabah;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class DataNasabahController extends Component
{
    use WithFileUploads;
    public $tbl_data_nasabah_id;
    public $nama_nasabah;
    public $nomor_hp;
    public $tanggal_lahir;
    public $jenis_kelamin;
    public $pekerjaan;
    public $status_perkawinan;
    public $tanggal_bergabung;
    public $alamat;
    public $tgl_pinjaman;

    // data set
    public $attribute_nilai_id = [];

    public $route_name = null;
    public $file = null;
    public $file_path = null;

    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataDataNasabahById', 'getDataNasabahId'];

    public function mount()
    {
        $this->route_name = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.nasabah.tbl-data-nasabah', [
            'items' => DataNasabah::all(),
            'attributes' => Attribute::where('status', 0)->get()
        ]);
    }

    public function store()
    {
        $this->_validate();

        $data = [
            'nama_nasabah'  => $this->nama_nasabah,
            'nomor_hp'  => $this->nomor_hp,
            'tanggal_lahir'  => $this->tanggal_lahir,
            'jenis_kelamin'  => $this->jenis_kelamin,
            'pekerjaan'  => $this->pekerjaan,
            'status_perkawinan'  => $this->status_perkawinan,
            'tanggal_bergabung'  => $this->tanggal_bergabung,
            'alamat'  => $this->alamat,
            'tgl_pinjaman'  => $this->tgl_pinjaman,
        ];

        $nasabah = DataNasabah::create($data);

        if (is_array($this->attribute_nilai_id)) {
            $data_to_store = [];
            foreach ($this->attribute_nilai_id as $key => $value) {
                $data_to_store[] = [
                    'data_nasabah_id' => $nasabah->id,
                    'attribute_nilai_id' => $value,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
            DataLatih::insert($data_to_store);
        }

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'nama_nasabah'  => $this->nama_nasabah,
            'nomor_hp'  => $this->nomor_hp,
            'tanggal_lahir'  => $this->tanggal_lahir,
            'jenis_kelamin'  => $this->jenis_kelamin,
            'pekerjaan'  => $this->pekerjaan,
            'status_perkawinan'  => $this->status_perkawinan,
            'tanggal_bergabung'  => $this->tanggal_bergabung,
            'alamat'  => $this->alamat,
            'tgl_pinjaman'  => $this->tgl_pinjaman,
        ];
        $row = DataNasabah::find($this->tbl_data_nasabah_id);

        $row->DataLatih()->delete();
        // update data setingan
        if (is_array($this->attribute_nilai_id)) {
            $data_to_store = [];
            foreach ($this->attribute_nilai_id as $key => $value) {
                $data_to_store[] = [
                    'data_nasabah_id' => $row->id,
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
    }

    public function delete()
    {
        DataNasabah::find($this->tbl_data_nasabah_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function saveImport()
    {
        Excel::import(new ImportsDataNasabah, $this->file_path);
        DataNasabah::where('nama_nasabah', null)->delete();
        $this->_reset();
    }

    public function _validate()
    {
        $rule = [
            // 'nama_nasabah'  => 'required',
            // 'nomor_hp'  => 'required',
            // 'tanggal_lahir'  => 'required',
            // 'jenis_kelamin'  => 'required',
            // 'pekerjaan'  => 'required',
            // 'status_perkawinan'  => 'required',
            // 'tanggal_bergabung'  => 'required',
            // 'alamat'  => 'required',
            'tgl_pinjaman'  => 'required',
        ];

        return $this->validate($rule);
    }

    public function getDataDataNasabahById($tbl_data_nasabah_id)
    {
        $this->_reset();
        $row = DataNasabah::find($tbl_data_nasabah_id);
        $this->tbl_data_nasabah_id = $row->id;
        $this->nama_nasabah = $row->nama_nasabah;
        $this->nomor_hp = $row->nomor_hp;
        $this->tanggal_lahir = date('Y-m-d', strtotime($row->tanggal_lahir));
        $this->jenis_kelamin = $row->jenis_kelamin;
        $this->pekerjaan = $row->pekerjaan;
        $this->status_perkawinan = $row->status_perkawinan;
        $this->tanggal_bergabung = $row->tanggal_bergabung;
        $this->alamat = $row->alamat;
        $this->tgl_pinjaman = $row->tgl_pinjaman;

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

    public function getDataNasabahId($tbl_data_nasabah_id)
    {
        $row = DataNasabah::find($tbl_data_nasabah_id);
        $this->tbl_data_nasabah_id = $row->id;
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
        $this->emit('showModalImport', 'hide');
        $this->tbl_data_nasabah_id = null;
        $this->nama_nasabah = null;
        $this->nomor_hp = null;
        $this->tanggal_lahir = null;
        $this->jenis_kelamin = null;
        $this->pekerjaan = null;
        $this->status_perkawinan = null;
        $this->tanggal_bergabung = null;
        $this->tgl_pinjaman = null;
        $this->alamat = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
