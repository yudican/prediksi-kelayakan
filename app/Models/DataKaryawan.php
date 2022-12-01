<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    //use Uuid;
    use HasFactory;
    protected $table = 'data_karyawan';

    //public $incrementing = false;

    protected $fillable = [
        'nik', 'nama', 'telepon', 'data_jabatan_id', 'eselon',
        'gol',
        'tmt',
        'email'
    ];

    protected $dates = [];

    /**
     * Get the jabatan that owns the DataKaryawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jabatan()
    {
        return $this->belongsTo(DataJabatan::class, 'data_jabatan_id');
    }

    /**
     * Get all of the dataLatih for the DataKaryawan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dataLatih()
    {
        return $this->hasMany(DataLatih::class, 'data_karyawan_id');
    }
}
