<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Attribute;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use App\Http\Livewire\Table\LivewireDatatable;

class AttributeTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'tbl_attributes';
    public $hide = [];

    public function builder()
    {
        return Attribute::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('id')->label('No.'),
            Column::name('nama_atribut')->label('Nama Atribut')->searchable(),
            Column::callback(['status'], function ($status) {
                if ($status == 1) {
                    return 'Atribut Akhir';
                }
                return 'Atribut Utama';
            })->label(__('Status')),
            Column::callback(['tbl_attributes.id', 'tbl_attributes.status'], function ($id, $status) {
                if ($status == 1) {
                    return '<button class="btn btn-success btn-sm">Atribut Akhir</button>';
                }
                return '<button class="btn btn-secondary btn-sm" wire:click="changeAttribute(' . $id . ')">Jadikan Atribut Akhir</button>';
            })->label(__('Status Atribut')),
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
        $this->emit('getDataAttributeById', $id);
    }

    public function getId($id)
    {
        $this->emit('getAttributeId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
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

    public function changeAttribute($id)
    {
        Attribute::where('status', 1)->update(['status' => 0]);
        Attribute::find($id)->update(['status' => 1]);
        $this->emit('refreshLivewireDatatable');
    }
}
