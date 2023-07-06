<?php

namespace App\Imports;

use App\Models\AttributeNilai;
use App\Models\DataLatih;
use App\Models\DataNasabah as ModelsDataNasabah;
use App\Models\DataSet;
use App\Models\DataSetDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataNasabah implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        try {
           $data = [
            'nama_nasabah'     => isset($row['nama_nasabah']) ? $row['nama_nasabah'] : '-',
            'nomor_hp'    => isset($row['nomor_hp']) ? $row['nomor_hp'] : '-',
            'tanggal_lahir' => isset($row['tanggal_lahir']) ? $row['tanggal_lahir'] :  '1990-01-01',
            'jenis_kelamin' => trim($row['jenis_kelamin']) == 'L' ? 'Laki-laki' : 'Perempuan',
            'tanggal_pinjaman' => isset($row['tanggal_pinjaman']) ? $row['tanggal_lahir'] : null,
            'status_pernikahan' => isset($row['status_pernikahan']) ?? 'Menikah',
        ];

        $nasabah = ModelsDataNasabah::create($data);

        $data_to_store = [
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue(trim($row['jenis_kelamin'])),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['tang']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['pepin']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['jenis_usaha']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['penpin']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DataLatih::insert($data_to_store);

        $data_set = DataSet::create(['kode' => 'SET-' . rand(123, 534) . '-' . rand(534, 796)]);
        $data_set_detail = [
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['tang']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['penpin']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['jenis_usaha']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['pepin']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['kategori']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_set_id' => $data_set->id,
                'attribute_nilai_id' => $this->getAttributrValue(trim($row['jenis_kelamin'])),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DataSetDetail::insert($data_set_detail);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }

    // public function headingRow(): int
    // {
    //     return 2;
    // }

    public function getAttributrValue($field)
    {
        $value = AttributeNilai::where('nilai_atribut', "$field")->first();
        if ($value) {
            return $value->id;
        }

        return null;
    }
}
