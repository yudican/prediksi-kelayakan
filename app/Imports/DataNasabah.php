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
        $data = [
            'nama_nasabah'     => $row['nama_nasabah'],
            'nomor_hp'    => $row['nomor_hp'],
            'tanggal_lahir' => $row['tanggal_lahir'],
            'jenis_kelamin' => $row['janis_kelamin'],
            'tanggal_pinjaman' => $row['tanggal_pinjaman'],
            'status_pernikahan' => $row['status_pernikahan'],
            'jumlah_tanggungan' => $row['jumlah_tanggungan'],
            'priode_pinjaman' => $row['priode_pinjaman'],
            'janis_usaha' => $row['janis_usaha'],
            'pencairan_pinjaman' => $row['pencairan_pinjaman'],
        ];

        $nasabah = ModelsDataNasabah::create($data);

        $data_to_store = [
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['status_pernikahan']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['jumlah_tanggungan']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['priode_pinjaman']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['janis_usaha']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'data_nasabah_id' => $nasabah->id,
                'attribute_nilai_id' => $this->getAttributrValue($row['pencairan_pinjaman']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DataLatih::insert($data_to_store);
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function getAttributrValue($field)
    {
        $value = AttributeNilai::where('nilai_atribut', 'like', "%$field%")->first();
        if ($value) {
            return $value->id;
        }

        return null;
    }
}
