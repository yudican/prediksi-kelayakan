<?php

namespace App\Imports;

use App\Models\AttributeNilai;
use App\Models\DataLatih;
use App\Models\DataNasabah as ModelsDataNasabah;
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
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['jenis_kelamin']], [
        //     'attribute_id' => 8,
        //     'nilai_atribut' => trim($row['jenis_kelamin']),
        // ]);
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['tang']], [
        //     'attribute_id' => 2,
        //     'nilai_atribut' => $row['tang'],
        // ]);
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['penpin']], [
        //     'attribute_id' => 3,
        //     'nilai_atribut' => $row['penpin'],
        // ]);
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['jenis_usaha']], [
        //     'attribute_id' => 4,
        //     'nilai_atribut' => $row['jenis_usaha'],
        // ]);
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['pepin']], [
        //     'attribute_id' => 5,
        //     'nilai_atribut' => $row['pepin'],
        // ]);
        // AttributeNilai::updateOrCreate(['nilai_atribut' => $row['kategori']], [
        //     'attribute_id' => 6,
        //     'nilai_atribut' => $row['kategori'],
        // ]);
        $data = [
            'nama_nasabah'     => $row['nama_nasabah'] ?? '-',
            'nomor_hp'    => $row['nomor_hp'] ?? '-',
            'tanggal_lahir' => $row['tanggal_lahir'] ?? '1990-01-01',
            'jenis_kelamin' => trim($row['jenis_kelamin']) == 'L' ? 'Laki-laki' : 'Perempuan',
            'tanggal_pinjaman' => $row['tanggal_pinjaman'] ?? null,
            'status_pernikahan' => $row['status_pernikahan'] ?? 'Menikah',
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
    }

    // public function headingRow(): int
    // {
    //     return 2;
    // }

    public function getAttributrValue($field)
    {
        $value = AttributeNilai::where('nilai_atribut', 'like', "%$field%")->first();
        if ($value) {
            return $value->id;
        }

        return null;
    }
}
