<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataNasabah;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;
use App\Models\DataSet;
use App\Models\DataSetDetail;
use Livewire\WithFileUploads;

class DataNasabahTable extends LivewireDatatable
{

    protected $listeners = ['refreshTable', 'hapusNasabah'];
    public $hideable = 'select';
    public $table_name = 'tbl_data_nasabah';
    public $hide = [];

    public function builder()
    {
        return DataNasabah::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::checkbox(),
            Column::name('id')->label('No.'),
            Column::name('nama_nasabah')->label('Nama Nasabah')->searchable(),
            // Column::name('nomor_hp')->label('Nomor Hp')->searchable(),
            // Column::name('tanggal_lahir')->label('Tanggal Lahir')->searchable(),
            // Column::name('jenis_kelamin')->label('Jenis Kelamin')->searchable(),
            // Column::name('pekerjaan')->label('Pekerjaan')->searchable(),
            // Column::name('status_perkawinan')->label('Status Perkawinan')->searchable(),
            // Column::name('tanggal_bergabung')->label('Tanggal Bergabung')->searchable(),
            // Column::name('alamat')->label('Alamat')->searchable(),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => $this->params
                ]);
            })->label(__('Aksi')),
        ];
    }

    public function getDataById($id)
    {
        $this->emit('getDataDataNasabahById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataNasabahId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function hapusNasabah()
    {
        if (count($this->selected) > 0) {
            DataNasabah::whereIn('id', $this->selected)->delete();
            $data_set = DataSet::all();
            foreach ($data_set as $key => $value) {
                DataSetDetail::where('data_set_id', $value->id)->delete();
                $value->delete();
            }
            $this->emit('refreshTable');
            return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
        }
        return $this->emit('showAlertError', ['msg' => 'Pilih Data Terlebih Dahulu']);
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
