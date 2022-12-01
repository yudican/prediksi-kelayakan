<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataNasabah extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_nasabah';
    //public $incrementing = false;

    protected $fillable = ['nama_nasabah', 'nomor_hp', 'tanggal_lahir', 'jenis_kelamin', 'pekerjaan', 'status_perkawinan', 'tanggal_bergabung', 'alamat'];

    protected $dates = ['tanggal_lahir'];

    /**
     * Get all of the dataLatih for the DataKaryawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataLatih()
    {
        return $this->hasMany(DataLatih::class, 'data_nasabah_id');
    }
}
